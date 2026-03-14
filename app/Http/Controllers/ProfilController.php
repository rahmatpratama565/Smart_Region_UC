<?php

namespace App\Http\Controllers;

use App\Models\DataWilayah;
use Illuminate\Support\Facades\DB;

class ProfilController extends Controller
{

public function index()
{

/* ========================
   STATISTIK GLOBAL
======================== */

$total = DataWilayah::count();

$valid = DataWilayah::where('status_validasi','valid')->count();

$pending = DataWilayah::where('status_validasi','pending')->count();

$ditolak = DataWilayah::where('status_validasi','ditolak')->count();



/* ========================
   GALERI FOTO TERBARU
======================== */

$fotos = DataWilayah::latest()
        ->limit(6)
        ->get();



/* ========================
   MAP DATA WILAYAH
======================== */

$mapData = DataWilayah::select(
        'nama_wilayah',
        DB::raw('AVG(latitude) as latitude'),
        DB::raw('AVG(longitude) as longitude'),
        DB::raw('AVG(progress) as progress')
    )
    ->whereNotNull('latitude')
    ->whereNotNull('longitude')
    ->groupBy('nama_wilayah')
    ->orderBy('nama_wilayah')
    ->get();



/* ========================
   RANKING WILAYAH
======================== */

$ranking = DataWilayah::select(
        'nama_wilayah',
        DB::raw('AVG(progress) as progress')
    )
    ->groupBy('nama_wilayah')
    ->orderByDesc('progress')
    ->limit(5)
    ->get();



/* ========================
   DATA GRAFIK BULANAN
======================== */

$monthlyData = DataWilayah::select(
        DB::raw('MONTH(created_at) as bulan'),
        DB::raw('COUNT(*) as total')
    )
    ->groupBy(DB::raw('MONTH(created_at)'))
    ->orderBy('bulan')
    ->get();



/* ========================
   RETURN VIEW
======================== */

return view('profil_wilayah',[
    'total' => $total,
    'valid' => $valid,
    'pending' => $pending,
    'ditolak' => $ditolak,
    'fotos' => $fotos,
    'mapData' => $mapData,
    'ranking' => $ranking,
    'monthlyData' => $monthlyData
]);

}

}