<?php

use App\Http\Controllers\PegawaiController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PegawaiController::class, 'index'])->name('pegawai.index');
Route::get('/pegawai/data', [PegawaiController::class, 'list']);
Route::post('/pegawai/store', [PegawaiController::class, 'store']);
Route::put('/pegawai/update/{id}', [PegawaiController::class, 'update']);
Route::delete('/pegawai/delete/{id}', [PegawaiController::class, 'destroy']);

Route::get('/api/provinsi', [PegawaiController::class, 'getProvinsi']);
Route::get('/api/kabkota/{provinsi_id}', [PegawaiController::class, 'getKabKota']);
Route::get('/api/kecamatan/{kabkota_id}', [PegawaiController::class, 'getKecamatan']);
Route::get('/api/kodepos/{kabkota_id}/{kecamatan_id}', [PegawaiController::class, 'getKodePos']);
