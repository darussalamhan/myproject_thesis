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
        $pemohon = Pemohon::has('nilai')->with(['nilai' => function ($query) {
            $query->with('sub_kriteria', 'tahun_nilai');
        }, 'hasil'])->get();        
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
            $pemohonName = $nilaiItem->pemohon ? $nilaiItem->pemohon->nama : 'Pemohon tidak ada atau terhapus.';

            foreach ($kriteria as $kriteriaItem) {
                // Check if $nilaiItem->sub_kriteria is not null
                if ($nilaiItem->sub_kriteria) {
                    // Check if the criteria is available
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
                } else {
                    // Handle the case where subkriteria is null or criteria is missing
                    $normalizedScores[$pemohonName][$kriteriaItem->id] = 1;
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

        return view('hasil_perhitungan.index', compact('pemohon', 'kriteria', 'normalizedScores', 'vectorS', 'vectorV', 'weights', 'nilai'));
    }

    public function store(Request $request)
    {
        try {
            $tahun_nilai = $request->input('pilih_tahun');
            
            // Retrieve $vectorV from the session
            $vectorV = session('vectorV');
            
            $rank = 1;
            foreach ($vectorV as $pemohonName => $vectorVValue) {
                // Find the Pemohon ID by name
                $pemohon = Pemohon::where('nama', $pemohonName)->first();
                
                // Check if a record with the same year and pemohon_id exists
                $existingRecord = Hasil::where('tahun_nilai', $tahun_nilai)
                    ->where('pemohon_id', $pemohon->id)
                    ->first();
                
                if ($existingRecord) {
                    // If the record exists, update it
                    $existingRecord->update([
                        'hasil' => $vectorVValue,
                        'rangking' => $rank,
                    ]);
                } else {
                    // If the record doesn't exist, create a new record
                    Hasil::create([
                        'pemohon_id' => $pemohon->id,
                        'hasil' => $vectorVValue,
                        'rangking' => $rank,
                        'tahun_nilai' => $tahun_nilai,
                    ]);
                }
                
                $rank++;
            }
            
            return back()->with('msg', 'Data hasil perhitungan berhasil disimpan!');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

}
