<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataWilayah;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;
use Illuminate\Support\Facades\DB;

class PemimpinController extends Controller
{

public function dashboard()
{

$total = DataWilayah::count();

$valid = DataWilayah::where('status_validasi','valid')->count();

$pending = DataWilayah::where('status_validasi','pending')->count();

$ditolak = DataWilayah::where('status_validasi','ditolak')->count();

$avgProgress = DataWilayah::avg('progress') ?? 0;


/* PROGRESS PER KECAMATAN */

$wilayah = DataWilayah::select(
'nama_wilayah',
DB::raw('AVG(progress) as progress')
)
->groupBy('nama_wilayah')
->orderBy('progress','desc')
->get();


/* TREND PEMBANGUNAN */

$trend = DataWilayah::select(
DB::raw('MONTH(tanggal_input) as bulan'),
DB::raw('AVG(progress) as progress')
)
->groupBy(DB::raw('MONTH(tanggal_input)'))
->orderBy('bulan')
->get();


/* RANKING WILAYAH */

$ranking = DataWilayah::select(
'nama_wilayah',
DB::raw('AVG(progress) as progress')
)
->groupBy('nama_wilayah')
->orderBy('progress','desc')
->take(5)
->get();


/* ALERT PROGRESS RENDAH */

$alert = DataWilayah::select(
'nama_wilayah',
DB::raw('AVG(progress) as progress')
)
->groupBy('nama_wilayah')
->havingRaw('AVG(progress) < 40')
->orderBy('progress','asc')
->get();


return view('pemimpin.dashboard',compact(
'total',
'valid',
'pending',
'ditolak',
'avgProgress',
'wilayah',
'trend',
'ranking',
'alert'
));

}


public function wilayah()
{

$data = DataWilayah::with('petugas')
->latest()
->get();

return view('pemimpin.wilayah.index',compact('data'));

}


public function detail($id)
{

$data = DataWilayah::with('petugas')->findOrFail($id);

return view('pemimpin.wilayah.detail',compact('data'));

}


public function laporan()
{

$data = DataWilayah::with('petugas')
->where('status_validasi','valid')
->latest()
->get();

return view('pemimpin.laporan.index',compact('data'));

}


public function exportPDF(Request $request)
{

$data = DataWilayah::with('petugas')
->where('status_validasi','valid')
->get();

$paper='A4';
$orientation='portrait';

if($request->type=='a4l'){
$orientation='landscape';
}

if($request->type=='f4p'){
$paper='legal';
}

if($request->type=='f4l'){
$paper='legal';
$orientation='landscape';
}

$pdf = Pdf::loadView('pemimpin.laporan.pdf',compact('data'))
->setPaper($paper,$orientation);

return $pdf->download('laporan_wilayah.pdf');

}


public function exportExcel()
{

return Excel::download(
new LaporanExport,
'laporan_wilayah.xlsx'
);

}

}