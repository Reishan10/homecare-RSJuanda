<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DokterController;
use App\Http\Controllers\Backend\PasienController;
use App\Http\Controllers\Backend\PerawatController;
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
    Route::post('/dokter/delete-multiple-dokter', [DokterController::class, 'deleteMultiple'])->name('delete-multiple-dokter');
    Route::get('/dokter', [DokterController::class, 'index'])->name('dokter.index');
    Route::get('/dokter/tambah', [DokterController::class, 'create'])->name('dokter.create');
    Route::post('/dokter', [DokterController::class, 'store'])->name('dokter.store');
    Route::get('/dokter/{dokter}/edit', [DokterController::class, 'edit'])->name('dokter.edit');
    Route::post('/dokter/{dokter}', [DokterController::class, 'update'])->name('dokter.update');
    Route::delete('dokter/{dokter}', [DokterController::class, 'destroy'])->name('dokter.destroy');

    //Perawat
    Route::post('/perawat/delete-multiple-perawat', [PerawatController::class, 'deleteMultiple'])->name('delete-multiple-perawat');
    Route::get('/perawat', [PerawatController::class, 'index'])->name('perawat.index');
    Route::get('/perawat/tambah', [PerawatController::class, 'create'])->name('perawat.create');
    Route::post('/perawat', [PerawatController::class, 'store'])->name('perawat.store');
    Route::get('/perawat/{perawat}/edit', [PerawatController::class, 'edit'])->name('perawat.edit');
    Route::post('/perawat/{perawat}', [PerawatController::class, 'update'])->name('perawat.update');
    Route::delete('perawat/{perawat}', [PerawatController::class, 'destroy'])->name('perawat.destroy');

    //Pasien
    Route::post('/pasien/delete-multiple-pasien', [PasienController::class, 'deleteMultiple'])->name('delete-multiple-pasien');
    Route::get('/pasien', [PasienController::class, 'index'])->name('pasien.index');
    Route::get('/pasien/tambah', [PasienController::class, 'create'])->name('pasien.create');
    Route::post('/pasien', [PasienController::class, 'store'])->name('pasien.store');
    Route::get('/pasien/{pasien}/edit', [PasienController::class, 'edit'])->name('pasien.edit');
    Route::post('/pasien/{pasien}', [PasienController::class, 'update'])->name('pasien.update');
    Route::delete('pasien/{pasien}', [PasienController::class, 'destroy'])->name('pasien.destroy');
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
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
