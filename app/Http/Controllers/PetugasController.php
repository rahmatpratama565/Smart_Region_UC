<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWilayah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{

/*
================================
DASHBOARD
================================
*/
public function dashboard()
{

$total = DataWilayah::where('user_id',Auth::id())->count();

$pending = DataWilayah::where('user_id',Auth::id())
->where('status_validasi','pending')
->count();

$valid = DataWilayah::where('user_id',Auth::id())
->where('status_validasi','valid')
->count();

$ditolak = DataWilayah::where('user_id',Auth::id())
->where('status_validasi','ditolak')
->count();

return view('petugas.dashboard',compact(
'total',
'pending',
'valid',
'ditolak'
));

}


/*
================================
LIST DATA
================================
*/
public function data()
{

$data = DataWilayah::where('user_id',Auth::id())
->latest()
->get();

return view('petugas.data.index',compact('data'));

}


/*
================================
FORM CREATE
================================
*/
public function create()
{

return view('petugas.data.create');

}


/*
================================
STORE DATA
================================
*/
public function store(Request $request)
{

$request->validate([

'nama_wilayah' => 'required',
'jenis_data' => 'required',
'target' => 'required|numeric',
'nilai_data' => 'required|numeric',
'tanggal_input' => 'required|date',

]);

$data = new DataWilayah();

$data->user_id = Auth::id();
$data->nama_wilayah = $request->nama_wilayah;
$data->jenis_data = $request->jenis_data;
$data->target = $request->target;
$data->nilai_data = $request->nilai_data;
$data->kendala = $request->kendala;
$data->tanggal_input = $request->tanggal_input;


/* HITUNG PROGRESS */
$progress = 0;

if($request->target > 0){

$progress = ($request->nilai_data / $request->target) * 100;

}

$data->progress = round($progress,2);


/* SIMPAN GPS */
$data->latitude = $request->latitude ?? null;
$data->longitude = $request->longitude ?? null;


/* STATUS */
$data->status_validasi = 'pending';


/*
UPLOAD FOTO
*/

$fotos = [];

if($request->hasFile('foto_dokumentasi')){

foreach($request->file('foto_dokumentasi') as $file){

$path = $file->store('dokumentasi','public');

$fotos[] = $path;

}

}

$data->foto_dokumentasi = $fotos;

$data->save();

return redirect('/petugas/data')
->with('success','Data berhasil ditambahkan');

}


/*
================================
FORM EDIT
================================
*/
public function edit($id)
{

$data = DataWilayah::where('user_id',Auth::id())
->findOrFail($id);

return view('petugas.data.edit',compact('data'));

}


/*
================================
UPDATE DATA
================================
*/
public function update(Request $request,$id)
{

$request->validate([

'nama_wilayah' => 'required',
'jenis_data' => 'required',
'target' => 'required|numeric',
'nilai_data' => 'required|numeric',
'tanggal_input' => 'required|date',

]);

$data = DataWilayah::where('user_id',Auth::id())
->findOrFail($id);

$data->nama_wilayah = $request->nama_wilayah;
$data->jenis_data = $request->jenis_data;
$data->target = $request->target;
$data->nilai_data = $request->nilai_data;
$data->kendala = $request->kendala;
$data->tanggal_input = $request->tanggal_input;


/* HITUNG PROGRESS */
$progress = 0;

if($request->target > 0){

$progress = ($request->nilai_data / $request->target) * 100;

}

$data->progress = round($progress,2);


/* UPDATE GPS */
$data->latitude = $request->latitude ?? $data->latitude;
$data->longitude = $request->longitude ?? $data->longitude;


/*
UPLOAD FOTO BARU
*/

if($request->hasFile('foto_dokumentasi')){

$fotos = $data->foto_dokumentasi ?? [];

foreach($request->file('foto_dokumentasi') as $file){

$path = $file->store('dokumentasi','public');

$fotos[] = $path;

}

$data->foto_dokumentasi = $fotos;

}

$data->save();

return redirect('/petugas/data')
->with('success','Data berhasil diupdate');

}


/*
================================
DELETE DATA
================================
*/
public function delete($id)
{

$data = DataWilayah::where('user_id',Auth::id())
->findOrFail($id);

/* HAPUS FOTO */

if($data->foto_dokumentasi){

foreach($data->foto_dokumentasi as $foto){

Storage::disk('public')->delete($foto);

}

}

$data->delete();

return redirect('/petugas/data')
->with('success','Data berhasil dihapus');

}

}