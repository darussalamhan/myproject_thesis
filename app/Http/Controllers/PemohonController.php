<?php

namespace App\Http\Controllers;

use App\Models\Pemohon;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PemohonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth')->except('show');
        $this->middleware('admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['pemohon'] = Pemohon::orderBy('nama', 'ASC')->get();
        return view('data_pemohon.index', $data);
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
            'no_kk' => [
                'required',
                'unique:pemohon,no_kk',
                'numeric',
                'digits:16', // Ensure 'no_kk' has exactly 16 digits
            ],
            'nama' => 'required|string',
            'nik'=> 'required|string|unique:pemohon,nik',
            'jenis_kelamin'=> 'required|string',
            'alamat' => 'required|string',
            'no_telp'=> 'required|string',
            'tahun_daftar' => 'required|numeric',
        ]);

        try {
            $pemohon = new Pemohon();
            $pemohon->no_kk = $request->no_kk;
            $pemohon->nama = $request->nama;
            $pemohon->nik = $request->nik;
            $pemohon->jenis_kelamin = $request->jenis_kelamin;
            $pemohon->alamat = $request->alamat;
            $pemohon->no_telp = $request->no_telp;
            $pemohon->tahun_daftar = $request->tahun_daftar;
            $pemohon->save();
            return back()->with('msg', 'Berhasil menambahkan data');
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data['pemohon'] = Pemohon::orderBy('nama', 'ASC')->get();
        return view('data_pemohon.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data['pemohon'] = Pemohon::findOrFail($id);
        return view('data_pemohon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'no_kk' => [
                'required',
                Rule::unique('pemohon', 'no_kk')->ignore($id),
                'numeric',
                'digits:16',
            ],
            'nama' => 'required|string',
            'nik' => [
                'required',
                Rule::unique('pemohon', 'nik')->ignore($id),
            ],
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            'no_telp' => 'required|string',
            'tahun_daftar' => 'required|numeric',
        ]);

        try {
            $pemohon = Pemohon::findOrFail($id);
            $pemohon->update([
                'no_kk' => $request->no_kk,
                'nama' => $request->nama,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'tahun_daftar' => $request->tahun_daftar,
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
            $pemohon = Pemohon::findOrFail($id);
            $pemohon->delete();
        } catch (\Exception $e) {
            Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            die("Gagal");
        }
    }
}
