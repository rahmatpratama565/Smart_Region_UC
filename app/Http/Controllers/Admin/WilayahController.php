<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataWilayah;
use Illuminate\Support\Facades\Auth;

class WilayahController extends Controller
{

/* =========================
   MONITORING WILAYAH
========================= */

public function index()
{

$data = DataWilayah::with('petugas')->latest()->get();

return view('admin.wilayah.index',compact('data'));

}


/* =========================
   VALIDASI DATA
========================= */

public function validasi($id)
{

$data = DataWilayah::with('petugas')->findOrFail($id);

return view('admin.wilayah.validasi',compact('data'));

}


/* =========================
   SETUJUI DATA
========================= */

public function setuju($id)
{

$data = DataWilayah::findOrFail($id);

$data->update([

'status_validasi'=>'valid',
'validated_by'=>Auth::id()

]);

return redirect('/admin/wilayah');

}


/* =========================
   TOLAK DATA
========================= */

public function tolak($id)
{

$data = DataWilayah::findOrFail($id);

$data->update([

'status_validasi'=>'ditolak',
'validated_by'=>Auth::id()

]);

return redirect('/admin/wilayah');

}


/* =========================
   REKAP LAPORAN (FITUR BARU)
========================= */

public function laporan()
{

$data = DataWilayah::with('petugas')
        ->latest()
        ->get();

return view('admin.laporan.index',compact('data'));

}


/* =========================
   DETAIL LAPORAN
========================= */

public function detail($id)
{

$data = DataWilayah::with('petugas')->findOrFail($id);

return view('admin.laporan.detail',compact('data'));

}


/* =========================
   HAPUS LAPORAN
========================= */

public function delete($id)
{

$data = DataWilayah::findOrFail($id);

$data->delete();

return redirect('/admin/laporan');

}

}