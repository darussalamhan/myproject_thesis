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
    public function index(Request $request)
    {
        // Retrieve distinct years from the Hasil table
        $distinctYears = Hasil::distinct()->pluck('tahun_nilai');

        // Retrieve data from the Hasil model and filter based on selected year if it's provided
        $hasilData = Hasil::with('pemohon')
            ->when($request->filled('tahun_nilai'), function ($query) use ($request) {
                // Filter data based on selected year if a year is provided
                $query->where('tahun_nilai', $request->input('tahun_nilai'));
            })
            ->orderBy('hasil', 'DESC')
            ->get();

        // Pass distinct years and hasilData to the "laporan" view
        return view('laporan.index', compact('distinctYears', 'hasilData'));
    }

    public function destroy(Request $request)
    {
        // Retrieve the selected year from the request
        $selectedYear = $request->input('tahun_nilai');

        try {
            // If no specific year is selected ("Semua Tahun"), delete all records
            if ($selectedYear === null) {
                Hasil::truncate(); // This will delete all records from the Hasil table
            } else {
                // If a specific year is selected, delete records based on the selected year
                Hasil::where('tahun_nilai', $selectedYear)->delete();
            }

            // Redirect back with a success message
            return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dihapus!');
        } catch (\Exception $e) {
            // Handle any exceptions that occur during the deletion process
            // Log the error if necessary
            // Redirect back with an error message
            return redirect()->route('laporan.index')->with('error', 'Gagal menghapus laporan: ' . $e->getMessage());
        }
    }

    public function print(Request $request)
    {
        // Retrieve the selected year from the request
        $selectedYear = $request->input('tahun_nilai');

        // If no specific year is selected ("Semua Tahun"), retrieve all data
        if ($selectedYear === null) {
            $hasilData = Hasil::with('pemohon')
                ->orderBy('hasil', 'DESC')
                ->get();
        } else {
            // If a specific year is selected, filter data based on the selected year
            $hasilData = Hasil::with('pemohon')
                ->where('tahun_nilai', $selectedYear)
                ->orderBy('hasil', 'DESC')
                ->get();
        }

        // Pass the selected year as a variable to the print view
        $tahunPengajuan = ($selectedYear === null) ? 'Semua Tahun' : $selectedYear;

        // Generate PDF
        $pdf = Pdf::loadView('laporan.print', compact('hasilData', 'tahunPengajuan'));

        // Download PDF
        return $pdf->download('laporan.pdf');
    }

}
