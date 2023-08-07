<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KriteriaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['kriteria'] = Kriteria::orderBy('nama_kriteria', 'ASC')->get();
        return view('kriteria.index', $data);
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
            'nama_kriteria' => 'required|string',
            'kode_kriteria' => 'required|string',
            'bobot' => 'required|numeric',
            'atribut' => 'required|string'
        ]);

        try {
            $kriteria = new Kriteria();
            $kriteria->nama_kriteria = $request->nama_kriteria;
            $kriteria->kode_kriteria = $request->kode_kriteria;
            $kriteria->bobot = $request->bobot;
            $kriteria->atribut = $request->atribut;
            $kriteria->save();
            return back()->with('msg', 'Berhasil menambahkan data');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $data['sub_kriteria'] = SubKriteria::where('kriteria_id', $id)->get();
        $data['kriteria'] = Kriteria::findOrFail($id);
        return view('kriteria.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['kriteria'] = Kriteria::findOrFail($id);
        return view('kriteria.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_kriteria' => 'required|string',
            'kode_kriteria' => 'required|string',
            'bobot' => 'required|numeric',
            'atribut' => 'required|string'
        ]);

        try {
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->update([
                'nama_kriteria' => $request->nama_kriteria,
                'kode_kriteria' => $request->kode_kriteria,
                'bobot' => $request->bobot,
                'atribut' => $request->atribut
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
            $kriteria = Kriteria::findOrFail($id);
            $kriteria->delete();
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
}
