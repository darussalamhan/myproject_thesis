<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use App\Models\Nilai;
use App\Models\Pemohon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected year from the query parameters or use the current year as default
        $selectedYear = $request->input('year', Carbon::now()->year);

        // Get unique registration years from Pemohon table
        $availableYears = Pemohon::orderBy('tahun_daftar')->distinct()->pluck('tahun_daftar');

        // Filter Pemohon records based on the selected year
        $pemohon = Pemohon::with('nilai.sub_kriteria')
                    ->where('tahun_daftar', $selectedYear) // Filter by selected year
                    ->orderBy('nama', 'ASC')
                    ->get();

        $kriteria = Kriteria::with('sub_kriteria')->orderBy('id', 'ASC')->get();

        // Pass the data to the view
        return view('penilaian.index', compact('pemohon', 'kriteria', 'availableYears', 'selectedYear'));
    }
    
    public function store(Request $request)
    {
        try {
            $selectedYear = $request->input('selected_year'); // Extract selected year from the form

            DB::select("TRUNCATE nilai");
            foreach ($request->pemohon_id as $key => $value) {
                foreach ($value as $key_1 => $value_1) {
                    Nilai::create([
                        'pemohon_id' => $key,
                        'subkriteria_id' => $value_1,
                        'tahun_nilai' => $selectedYear, // Store the selected year in the "nilai" table
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
