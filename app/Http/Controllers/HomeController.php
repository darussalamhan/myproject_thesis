<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kriteria;
use App\Models\Pemohon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $kriteria = Kriteria::count();
        $pemohon = Pemohon::count();

        $widget = [
            'users' => $users,
            'kriteria' => $kriteria,
            'pemohon' => $pemohon,
            //...
        ];

        return view('home', compact('widget'));
    }
}
