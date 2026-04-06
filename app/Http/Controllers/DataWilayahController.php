<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWilayah;
use Illuminate\Support\Facades\Auth;

class DataWilayahController extends Controller
{

public function index()
{
    $data = DataWilayah::where('user_id',Auth::id())->get();
    return view('petugas.data.index',compact('data'));
}

public function create()
{
    return view('petugas.data.create');
}

public function store(Request $request)
{
    $fotos = [];

    if($request->hasFile('foto_dokumentasi')){
        foreach($request->file('foto_dokumentasi') as $foto){
            $path = $foto->store('dokumentasi','public');
            $fotos[] = $path;
        }
    }

    /* hitung progress otomatis */
    $progress = 0;

    if($request->target > 0){
        $progress = ($request->nilai_data / $request->target) * 100;
    }

    DataWilayah::create([
        'user_id'=>Auth::id(),
        'nama_wilayah'=>$request->nama_wilayah,
        'jenis_data'=>$request->jenis_data,
        'target'=>$request->target,
        'nilai_data'=>$request->nilai_data,
        'progress'=>$progress,
        'kendala'=>$request->kendala,
        'tanggal_input'=>$request->tanggal_input,

        // ✅ PERBAIKAN (TAMBAH INI SAJA)
        'latitude'=>$request->latitude,
        'longitude'=>$request->longitude,

        'foto_dokumentasi'=>$fotos ?: null
    ]);

    return redirect('/petugas/data');
}

public function edit($id)
{
    $data = DataWilayah::findOrFail($id);
    return view('petugas.data.edit',compact('data'));
}

public function update(Request $request,$id)
{
    $data = DataWilayah::findOrFail($id);

    $fotos = $data->foto_dokumentasi ?? [];

    if($request->hasFile('foto_dokumentasi')){
        foreach($request->file('foto_dokumentasi') as $foto){
            $path = $foto->store('dokumentasi','public');
            $fotos[] = $path;
        }
    }

    $progress = 0;

    if($request->target > 0){
        $progress = ($request->nilai_data / $request->target) * 100;
    }

    $data->update([
        'nama_wilayah'=>$request->nama_wilayah,
        'jenis_data'=>$request->jenis_data,
        'target'=>$request->target,
        'nilai_data'=>$request->nilai_data,
        'progress'=>$progress,
        'kendala'=>$request->kendala,
        'tanggal_input'=>$request->tanggal_input,

        // ✅ PERBAIKAN (TAMBAH INI SAJA)
        'latitude'=>$request->latitude,
        'longitude'=>$request->longitude,

        'foto_dokumentasi'=>$fotos
    ]);

    return redirect('/petugas/data');
}

public function destroy($id)
{
    $data = DataWilayah::findOrFail($id);
    $data->delete();
    return back();
}

}