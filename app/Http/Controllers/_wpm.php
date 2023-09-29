<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Nilai;
use App\Models\Pemohon;
use Illuminate\Http\Request;

class HasilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pemohon = Pemohon::with('nilai.sub_kriteria')->get();
        $kriteria = Kriteria::with('sub_kriteria')->orderBy('nama_kriteria', 'ASC')->get();
        $nilai = Nilai::with('sub_kriteria', 'pemohon')->get();

        if (count($nilai) == 0) {
            return redirect(route('penilaian.index'));
        }

        $weights = []; // Array to store the weights of criteria

        // Prepare weights array from the criteria
        foreach ($kriteria as $value) {
            $weights[$value->id] = $value->bobot;
        }

        $normalizedScores = []; // Array to store normalized scores

        // Calculate normalized scores
        foreach ($nilai as $value_1) {
            foreach ($kriteria as $value) {
                if ($value->id == $value_1->sub_kriteria->kriteria_id) {
                    if ($value->atribut == 'benefit') {
                        $normalizedScores[$value_1->pemohon->nama][$value->id] = $value_1->sub_kriteria->bobot / max(array_column($nilai->where('sub_kriteria.kriteria_id', $value->id), 'sub_kriteria.bobot'));
                    } elseif ($value->atribut == 'cost') {
                        $normalizedScores[$value_1->pemohon->nama][$value->id] = min(array_column($nilai->where('sub_kriteria.kriteria_id', $value->id), 'sub_kriteria.bobot')) / $value_1->sub_kriteria->bobot;
                    }
                }
            }
        }

        $rank = []; // Array to store ranked results

        // Calculate weighted product and rank
        foreach ($normalizedScores as $key => $value) {
            $rank[$key] = 1;
            foreach ($kriteria as $value_1) {
                $rank[$key] *= pow($value[$value_1->id], $weights[$value_1->id]);
            }
        }

        arsort($rank);

        return view('hasil_perhitungan.index', compact('pemohon', 'kriteria', 'normalizedScores', 'rank'));
    }
}
