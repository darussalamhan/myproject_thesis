<?php

use App\Http\Controllers\HasilController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UserController;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Login route
Auth::routes();

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::get('/', 'HomeController@index')->name('home');

Route::get('/user', [UserController::class, 'index'])->name('user');

Route::resource("kriteria", "KriteriaController")->except(['create'])->middleware('auth');

Route::resource("subkriteria", "SubKriteriaController")->except(['index', 'create', 'show'])->middleware('auth');

Route::resource("pemohon", "PemohonController")->except(['create', 'show'])->middleware('auth');

Route::get('/penilaian', [NilaiController::class, 'index'])->name('penilaian');

Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');

Route::get('/laporan', [HasilController::class, 'index'])->name('laporan');