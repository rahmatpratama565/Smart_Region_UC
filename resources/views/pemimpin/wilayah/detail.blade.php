@extends('layouts.pemimpin')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
.card {
    border-radius: 14px;
}

.label-title {
    font-size: 13px;
    color: #888;
}

.value-box {
    background: #f8f9fa;
    padding: 10px 12px;
    border-radius: 8px;
    font-weight: 500;
}

.gallery img {
    width: 100px;
    height: 100px;
    object-fit: cover;
    border-radius: 10px;
    cursor: pointer;
    border: 1px solid #ddd;
}

.progress {
    height: 8px;
}

@media(max-width:768px) {
    .gallery img {
        width: 80px;
        height: 80px;
    }
}
</style>

<h4 class="mb-4 fw-bold">Detail Monitoring Wilayah</h4>

<!-- ================= CARD UTAMA ================= -->
<div class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="row">

            <!-- PETUGAS -->
            <div class="col-md-4 mb-3">
                <div class="label-title">Petugas</div>
                <div class="value-box">{{ $data->petugas->name }}</div>
            </div>

            <!-- WILAYAH -->
            <div class="col-md-4 mb-3">
                <div class="label-title">Wilayah</div>
                <div class="value-box">{{ $data->nama_wilayah }}</div>
            </div>

            <!-- JENIS -->
            <div class="col-md-4 mb-3">
                <div class="label-title">Jenis Data</div>
                <div class="value-box">{{ $data->jenis_data }}</div>
            </div>

            <!-- TARGET -->
            <div class="col-md-3 mb-3">
                <div class="label-title">Target</div>
                <div class="value-box">{{ $data->target }}</div>
            </div>

            <!-- REALISASI -->
            <div class="col-md-3 mb-3">
                <div class="label-title">Realisasi</div>
                <div class="value-box">{{ $data->nilai_data }}</div>
            </div>

            <!-- TANGGAL -->
            <div class="col-md-3 mb-3">
                <div class="label-title">Tanggal</div>
                <div class="value-box">{{ $data->tanggal_input }}</div>
            </div>

            <!-- STATUS -->
            <div class="col-md-3 mb-3">
                <div class="label-title">Status</div>

                @if($data->status_validasi == 'pending')
                <span class="badge bg-warning text-dark">Pending</span>
                @elseif($data->status_validasi == 'valid')
                <span class="badge bg-success">Valid</span>
                @else
                <span class="badge bg-danger">Ditolak</span>
                @endif

            </div>

        </div>

        <!-- PROGRESS -->
        <div class="mt-3">
            <div class="label-title mb-1">Progress</div>

            @php
            $progress = $data->progress ?? 0;
            $color = 'bg-danger';
            if($progress >= 70) $color = 'bg-success';
            elseif($progress >= 40) $color = 'bg-warning';
            @endphp

            <div class="progress">
                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%">
                </div>
            </div>

            <small class="fw-semibold">{{ round($progress,1) }}%</small>
        </div>

    </div>
</div>

<!-- ================= KENDALA ================= -->
<div class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="label-title mb-2">Kendala</div>

        <div class="value-box" style="min-height:60px">
            {{ $data->kendala ?? 'Tidak ada kendala' }}
        </div>

    </div>

</div>

<!-- ================= DOKUMENTASI ================= -->
<div class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="label-title mb-3">Dokumentasi</div>

        @if($data->foto_dokumentasi && count($data->foto_dokumentasi))

        <div class="gallery d-flex flex-wrap gap-2">

            @foreach($data->foto_dokumentasi as $foto)

            <img src="{{ asset('storage/'.$foto) }}" onclick="previewImage(this.src)">

            @endforeach

        </div>

        @else

        <div class="text-muted">Tidak ada dokumentasi</div>

        @endif

    </div>

</div>

<!-- ================= MAP ================= -->
@if($data->latitude && $data->longitude)

<div class="card shadow-sm mb-4">

    <div class="card-body">

        <div class="label-title mb-3">Lokasi Wilayah</div>

        <div id="map" style="height:300px;border-radius:10px;"></div>

    </div>

</div>

@endif

<!-- ================= BUTTON ================= -->
<a href="/pemimpin/wilayah" class="btn btn-secondary">
    <i class="fa fa-arrow-left"></i> Kembali
</a>

<!-- ================= MODAL IMAGE ================= -->
<div class="modal fade" id="imageModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0">
            <div class="modal-body p-0">
                <img id="previewImg" style="width:100%">
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(src) {
    document.getElementById('previewImg').src = src;
    new bootstrap.Modal(document.getElementById('imageModal')).show();
}
</script>

@if($data->latitude && $data->longitude)

@php
$lat = $data->latitude;
$lng = $data->longitude;
@endphp

<script>
let lat = @json($lat);
let lng = @json($lng);

let map = L.map('map').setView([lat, lng], 15);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

L.marker([lat, lng]).addTo(map);
</script>

@endif

@endsection