<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DataWilayah;
use App\Models\LoginLog;
use Illuminate\Support\Facades\DB;

/* TAMBAHAN EXPORT */
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class AdminController extends Controller
{

public function dashboard()
{

/* USER */

$totalPetugas = User::where('role','petugas')->count();
$totalPemimpin = User::where('role','pemimpin')->count();


/* STATUS VALIDASI */

$pending = DataWilayah::where('status_validasi','pending')->count();
$valid   = DataWilayah::where('status_validasi','valid')->count();
$ditolak = DataWilayah::where('status_validasi','ditolak')->count();


/* TOTAL DATA */

$totalWilayah = DataWilayah::count();


/* LOGIN */

$loginHariIni = LoginLog::whereDate('created_at', now())->count();
$loginGagal   = LoginLog::where('status','failed')->count();


/* RECENT */

$recentLogins  = LoginLog::latest()->limit(5)->get();
$recentWilayah = DataWilayah::latest()->limit(5)->get();


/* BRUTE FORCE */

$bruteforce = LoginLog::select(
    'ip_address',
    DB::raw('count(*) as total'),
    DB::raw('max(created_at) as last_attempt')
)
->where('status','failed')
->groupBy('ip_address')
->having('total','>=3')
->get();


/* PROGRESS TOTAL */

$avgProgress = DataWilayah::avg('progress') ?? 0;


/* PROGRESS PER WILAYAH */

$progressWilayah = DataWilayah::select(
    'nama_wilayah',
    DB::raw('AVG(progress) as progress')
)
->groupBy('nama_wilayah')
->orderBy('nama_wilayah')
->get();


/* =========================
   RANKING WILAYAH
========================= */

$rankingWilayah = DataWilayah::select(
    'nama_wilayah',
    DB::raw('AVG(progress) as progress')
)
->groupBy('nama_wilayah')
->orderByDesc('progress')
->limit(5)
->get();


/* GRAFIK WILAYAH */

$wilayahChart = DataWilayah::select(
    'nama_wilayah',
    DB::raw('count(*) as total')
)
->groupBy('nama_wilayah')
->orderBy('nama_wilayah')
->get();


/* DATA BULANAN */

$monthlyData = DataWilayah::select(
    DB::raw('MONTH(created_at) as bulan'),
    DB::raw('count(*) as total')
)
->groupBy('bulan')
->orderBy('bulan')
->get();


/* MAP DATA */

$mapData = DataWilayah::select(
    'nama_wilayah',
    'latitude',
    'longitude',
    'progress'
)
->whereNotNull('latitude')
->whereNotNull('longitude')
->get();


return view('admin.dashboard', compact(
'totalPetugas',
'totalPemimpin',
'pending',
'valid',
'ditolak',
'totalWilayah',
'loginHariIni',
'loginGagal',
'recentLogins',
'recentWilayah',
'bruteforce',
'avgProgress',
'progressWilayah',
'rankingWilayah',
'wilayahChart',
'monthlyData',
'mapData'
));

}


/* =====================================
   EXPORT PDF REKAP LAPORAN
===================================== */

public function exportPDF()
{

$data = DataWilayah::with('petugas')->get();

$pdf = Pdf::loadView('admin.laporan.pdf', compact('data'));

return $pdf->download('rekap_laporan_wilayah.pdf');

}


/* =====================================
   EXPORT EXCEL REKAP LAPORAN
===================================== */

public function exportExcel()
{

return Excel::download(new LaporanExport, 'rekap_laporan_wilayah.xlsx');

}


}