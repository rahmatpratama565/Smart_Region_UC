<?php

use Illuminate\Support\Facades\Route;

/* AUTH */
use App\Http\Controllers\AuthController;

/* PROFIL */
use App\Http\Controllers\ProfilController;

/* PETUGAS */
use App\Http\Controllers\PetugasController;

/* PEMIMPIN */
use App\Http\Controllers\PemimpinController;

/* ADMIN */
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\WilayahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SecurityController;



/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', [ProfilController::class,'index']);
Route::get('/profil_wilayah', [ProfilController::class,'index'])->name('profil');



/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function(){

Route::get('/login',[AuthController::class,'adminLoginForm'])->name('admin.login');
Route::post('/login',[AuthController::class,'adminLogin']);

});

Route::prefix('petugas')->group(function(){

Route::get('/login',[AuthController::class,'petugasLoginForm'])->name('petugas.login');
Route::post('/login',[AuthController::class,'petugasLogin']);

});

Route::prefix('pemimpin')->group(function(){

Route::get('/login',[AuthController::class,'pemimpinLoginForm'])->name('pemimpin.login');
Route::post('/login',[AuthController::class,'pemimpinLogin']);

});



/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::get('/logout',[AuthController::class,'logout'])->name('logout');



/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['authcheck'])->group(function(){



/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function(){

Route::get('/',[AdminController::class,'dashboard'])->name('admin.dashboard');


Route::get('/users',[UserController::class,'index']);
Route::get('/users/create',[UserController::class,'create']);
Route::post('/users/store',[UserController::class,'store']);
Route::get('/users/edit/{id}',[UserController::class,'edit']);
Route::post('/users/update/{id}',[UserController::class,'update']);
Route::get('/users/toggle/{id}',[UserController::class,'toggleStatus']);
Route::get('/users/delete/{id}',[UserController::class,'destroy']);


Route::get('/wilayah',[WilayahController::class,'index']);
Route::get('/wilayah/validasi/{id}',[WilayahController::class,'validasi']);
Route::get('/wilayah/setuju/{id}',[WilayahController::class,'setuju']);
Route::get('/wilayah/tolak/{id}',[WilayahController::class,'tolak']);


Route::get('/laporan',[WilayahController::class,'laporan']);
Route::get('/laporan/detail/{id}',[WilayahController::class,'detail']);
Route::get('/laporan/delete/{id}',[WilayahController::class,'delete']);

Route::get('/laporan/pdf',[AdminController::class,'exportPDF']);
Route::get('/laporan/excel',[AdminController::class,'exportExcel']);

Route::get('/security',[SecurityController::class,'index']);

});



/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::prefix('petugas')->group(function(){

Route::get('/',[PetugasController::class,'dashboard'])->name('petugas.dashboard');

Route::get('/data',[PetugasController::class,'data']);
Route::get('/data/create',[PetugasController::class,'create']);
Route::post('/data/store',[PetugasController::class,'store']);
Route::get('/data/edit/{id}',[PetugasController::class,'edit']);
Route::post('/data/update/{id}',[PetugasController::class,'update']);
Route::get('/data/delete/{id}',[PetugasController::class,'delete']);

});



/*
|--------------------------------------------------------------------------
| PEMIMPIN
|--------------------------------------------------------------------------
*/

Route::prefix('pemimpin')->group(function(){

Route::get('/',[PemimpinController::class,'dashboard'])->name('pemimpin.dashboard');

Route::get('/wilayah',[PemimpinController::class,'wilayah']);
Route::get('/wilayah/{id}',[PemimpinController::class,'detail']);

Route::get('/laporan',[PemimpinController::class,'laporan']);

Route::get('/laporan/pdf',[PemimpinController::class,'exportPDF']);
Route::get('/laporan/excel',[PemimpinController::class,'exportExcel']);

});

});