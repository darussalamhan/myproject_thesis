<?php

use App\Http\Controllers\HasilController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PemohonController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UserController;
use App\Models\Kriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CustomAccessMiddleware;

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
Auth::routes(['register' => false]);

// Logout route
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
});

Route::group(['middleware' => [CustomAccessMiddleware::class]], function () {
    // Define your restricted routes here
    
    Route::get('/', 'HomeController@index')->name('home')->middleware('auth');
    
    Route::resource("kriteria", "KriteriaController")->except(['create'])->middleware('admin');
    
    Route::resource("subkriteria", "SubKriteriaController")->except(['create', 'show'])->middleware('admin')->parameters(['subkriteria' => 'kriteria_id']); // Add this line
    
    Route::resource("pemohon", "PemohonController")->except(['create'])->middleware('auth');
    Route::get('pemohon/show', 'PemohonController@show')->name('pemohon.show')->middleware('auth');
    
    Route::resource('penilaian', 'NilaiController')->middleware('auth')->middleware('nonadmin');
    
    Route::resource('hasil', 'HasilController')->middleware('auth')->middleware('nonadmin');
    
    Route::get('laporan', 'LaporanController@index')->name('laporan.index')->middleware('auth');
    Route::delete('laporan', 'LaporanController@destroy')->name('laporan.destroy')->middleware('nonadmin');
    Route::get('laporan/print', 'LaporanController@print')->name('laporan.print')->middleware('auth');
});


