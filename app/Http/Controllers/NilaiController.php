<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Pemohon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class NilaiController extends Controller
{
    public function index()
    {
        $pemohon = Pemohon::with('nilai.sub_kriteria')->get();        
        $kriteria = Kriteria::with('sub_kriteria')->orderBy('nama_kriteria', 'ASC')->get();
        return view('penilaian.index', compact('pemohon', 'kriteria'));
    }

    public function store(Request $request)
    {
        try {
            DB::select("TRUNCATE nilai");
            foreach ($request->pemohon_id as $key => $value) {
                foreach ($value as $key_1 => $value_1) {
                    Nilai::create([
                        'pemohon_id' => $key,
                        'subkriteria_id' => $value_1
                    ]);
                }
            }
            return back()->with('msg', 'Berhasil disimpan!');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
}
