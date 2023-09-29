<?php

namespace App\Http\Controllers;

use App\Models\Hasil;
use App\Models\Pemohon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve data from the pemohon table
        $pemohonData = Pemohon::select('id', 'nama', 'no_kk', 'alamat')->get();

        // Retrieve data from the Hasil model
        $hasilData = Hasil::with('pemohon.sub_kriteria')->orderBy('hasil', 'DESC')->get();

        // Pass the data to the "laporan" view
        return view('laporan.index', compact('pemohonData', 'hasilData'));
    }
    public function print()
    {
        // Retrieve data from the Hasil model
        $hasilData = Hasil::with('pemohon')->orderBy('hasil', 'DESC')->get();

        // Generate PDF
        $pdf = Pdf::loadView('laporan.print', compact('hasilData'));

        // Download PDF
        return $pdf->download('laporan.pdf');
    }
}
