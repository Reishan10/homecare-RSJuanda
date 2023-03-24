<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DokterController;
use App\Http\Controllers\HomeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    return view('backend.dashboard');
});


Auth::routes();

/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:Pasien'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:Administrator'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    //Dokter
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
});

/*------------------------------------------
--------------------------------------------
All Perawat Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:Perawat'])->group(function () {
    Route::get('/perawat/home', [HomeController::class, 'perawatHome'])->name('perawat.home');
});

/*------------------------------------------
--------------------------------------------
All Dokter Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:Dokter'])->group(function () {
    Route::get('/dokter/home', [HomeController::class, 'dokterHome'])->name('dokter.home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
