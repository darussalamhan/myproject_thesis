<?php

namespace App\Http\Controllers;

use App\Models\SubKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SubKriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('errors.custom_error');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_pilihan' => 'required|string',
            'bobot' => 'required|numeric'
        ]);

        try {
            $sub_kriteria = new SubKriteria();
            $sub_kriteria->kriteria_id = $request->kriteria_id;
            $sub_kriteria->nama_pilihan = $request->nama_pilihan;
            $sub_kriteria->bobot = $request->bobot;
            $sub_kriteria->save();
            return back()->with('msg', 'Berhasil menambahkan data');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SubKriteria $subKriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sub_kriteria = SubKriteria::findOrFail($id);
        $kriteria = Kriteria::findOrFail($sub_kriteria->kriteria_id);

        return view('sub_kriteria.edit', compact('sub_kriteria', 'kriteria'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_pilihan' => 'required|string',
            'bobot' => 'required|numeric'
        ]);        
        try {
            $sub_kriteria = SubKriteria::findOrFail($id);
            $sub_kriteria->update([
                'nama_pilihan' => $request->nama_pilihan,
                'bobot' => $request->bobot
            ]);
            return back()->with('msg', 'Berhasil mengubah data');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $sub_kriteria = SubKriteria::findOrFail($id);
            $sub_kriteria->delete();
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
}
