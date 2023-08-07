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
        return view('sub_kriteria.index');
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
            'bobot' => 'required|numberic'
        ]);

        try {
            $sub_kriteria = new SubKriteria();
            $sub_kriteria->kriteria_id = $request->kriteria_id;
            $sub_kriteria->nama_pilihan = $request->nama_pilihan;
            $sub_kriteria->bobot = $request->bobot;
            $sub_kriteria->save();
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
        $data['sub_kriteria'] = SubKriteria::findOrFail($id);
        $data['Kriteria'] = Kriteria::get();

        return view('sub_kriteria.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {        
        try {
            $sub_kriteria = SubKriteria::findOrFail($id);
            $sub_kriteria->update([
                'kriteria_id' => $request->kriteria_id,
                'nama_pilihan' => $request->nama_pilihan,
                'bobot' => $request->bobot
            ]);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubKriteria $subKriteria)
    {
        //
    }
}
