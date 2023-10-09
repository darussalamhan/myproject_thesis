<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Pemohon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HasilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pemohon = Pemohon::with('nilai.sub_kriteria')->get();
        $kriteria = Kriteria::with('sub_kriteria')->orderBy('id', 'ASC')->get();
        $nilai = Nilai::with('sub_kriteria', 'pemohon')->get();

        if (count($nilai) == 0) {
            return redirect(route('penilaian.index'));
        }

        // Step 1: Prepare weights array from the criteria
        $weights = [];
        $totalWeight = 0;

        foreach ($kriteria as $kriteriaItem) {
            $totalWeight += $kriteriaItem->bobot;
        }

        foreach ($kriteria as $kriteriaItem) {
            $weights[$kriteriaItem->id] = $kriteriaItem->bobot / $totalWeight;
        }

        // Step 2: Calculate normalized scores and store them in normalizedScores array
        $normalizedScores = [];

        foreach ($nilai as $nilaiItem) {
            $pemohonName = $nilaiItem->pemohon->nama;
            foreach ($kriteria as $kriteriaItem) {
                if ($kriteriaItem->id == $nilaiItem->sub_kriteria->kriteria_id) {
                    if ($kriteriaItem->atribut == 'benefit') {
                        $normalizedScores[$pemohonName][$kriteriaItem->id] = pow(
                            $nilaiItem->sub_kriteria->bobot,
                            $weights[$kriteriaItem->id]
                        );
                    } elseif ($kriteriaItem->atribut == 'cost') {
                        $normalizedScores[$pemohonName][$kriteriaItem->id] = pow(
                            $nilaiItem->sub_kriteria->bobot,
                            -$weights[$kriteriaItem->id]
                        );
                    }
                }
            }
        }

        // Step 3: Calculate vector S values
        $vectorS = [];

        foreach ($normalizedScores as $pemohonName => $criteriaScores) {
            $vectorS[$pemohonName] = 1;
            foreach ($criteriaScores as $kriteriaId => $criteriaScore) {
                $vectorS[$pemohonName] *= $criteriaScore;
            }
        }

        // Step 4: Calculate vector V values
        $vectorV = [];

        // Calculate the total sum of vector S
        $totalVectorS = array_sum($vectorS);
        foreach ($normalizedScores as $pemohonName => $criteriaScores) {
            // Calculate the vector V value for each pemohonName
            $vectorV[$pemohonName] = $vectorS[$pemohonName] / $totalVectorS;
        }
        arsort($vectorV);

        // Store $vectorV in the session
        session(['vectorV' => $vectorV]);

        return view('hasil_perhitungan.index', compact('pemohon', 'kriteria', 'normalizedScores', 'vectorS', 'vectorV', 'weights'));
    }

    public function store(Request $request)
    {
        try {
            DB::table('hasil')->truncate(); // Truncate the table before inserting new data
            
            // Retrieve $vectorV from the session
            $vectorV = session('vectorV');
            
            $rank = 1;
            foreach ($vectorV as $pemohonName => $vectorVValue) {
                // Find the Pemohon ID by name
                $pemohon = Pemohon::where('nama', $pemohonName)->first();
                
                // Calculate the vector V value for each pemohonName
                Hasil::create([
                    'pemohon_id' => $pemohon->id,
                    'hasil' => $vectorVValue,
                    'rangking' => $rank,
                ]);
                
                $rank++;
            }
            
            return back()->with('msg', 'Berhasil disimpan!');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
}
