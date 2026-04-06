@extends('layouts.pemimpin')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
/* ================= TABLE FIX ================= */
.table {
    table-layout: fixed;
    width: 100%;
}

.table th,
.table td {
    text-align: center;
    vertical-align: middle;
}

/* WIDTH KOLOM */
.col-no {
    width: 60px;
}

.col-petugas {
    width: 180px;
}

.col-wilayah {
    width: 200px;
}

.col-progress {
    width: 220px;
}

.col-lokasi {
    width: 120px;
}

.col-status {
    width: 120px;
}

.col-aksi {
    width: 100px;
}

/* TEXT RAPAT */
.text-truncate-custom {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* PROGRESS */
.progress {
    height: 8px;
    margin-bottom: 4px;
}

/* CARD */
.mobile-card {
    border-radius: 12px;
    background: white;
}

/* HOVER */
.table-hover tbody tr:hover {
    background: #f9fafb;
}
</style>

<h4 class="mb-4 fw-bold">Monitoring Wilayah</h4>

<!-- ================= DESKTOP ================= -->
<div class="card shadow-sm d-none d-md-block">

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-petugas">Petugas</th>
                        <th class="col-wilayah">Wilayah</th>
                        <th class="col-progress">Progress</th>
                        <th class="col-lokasi">Lokasi</th>
                        <th class="col-status">Status</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($data as $d)

                    @php
                    $progress = $d->progress ?? 0;
                    $color = $progress >=70 ? 'bg-success' : ($progress >=40 ? 'bg-warning' : 'bg-danger');
                    @endphp

                    <tr>

                        <td class="col-no">{{ $loop->iteration }}</td>

                        <td class="col-petugas text-truncate-custom">
                            {{ $d->petugas->name }}
                        </td>

                        <td class="col-wilayah fw-semibold text-truncate-custom">
                            {{ $d->nama_wilayah }}
                        </td>

                        <td class="col-progress">

                            <div class="progress">
                                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%"></div>
                            </div>

                            <small>{{ round($progress) }}%</small>

                        </td>

                        <td class="col-lokasi">

                            @if($d->latitude && $d->longitude)

                            <button class="btn btn-sm btn-success"
                                onclick="showMap({{ $d->latitude }}, {{ $d->longitude }})">
                                <i class="fa fa-map"></i>
                            </button>

                            @else
                            <span class="text-muted">-</span>
                            @endif

                        </td>

                        <td class="col-status">

                            @if($d->status_validasi=='valid')
                            <span class="badge bg-success">Valid</span>

                            @elseif($d->status_validasi=='pending')
                            <span class="badge bg-warning text-dark">Pending</span>

                            @else
                            <span class="badge bg-danger">Ditolak</span>
                            @endif

                        </td>

                        <td class="col-aksi">

                            <a href="/pemimpin/wilayah/{{ $d->id }}" class="btn btn-primary btn-sm">
                                <i class="fa fa-eye"></i>
                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>
                        <td colspan="7" class="text-center text-muted">
                            Tidak ada data monitoring wilayah
                        </td>
                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- ================= MOBILE ================= -->
<div class="d-md-none">

    @foreach($data as $d)

    @php
    $progress = $d->progress ?? 0;
    $color = $progress >=70 ? 'bg-success' : ($progress >=40 ? 'bg-warning' : 'bg-danger');
    @endphp

    <div class="mobile-card shadow-sm p-3 mb-3">

        <div class="fw-bold">{{ $d->nama_wilayah }}</div>
        <small class="text-muted">{{ $d->petugas->name }}</small>

        <div class="mt-2">
            <div class="progress">
                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%"></div>
            </div>
            <small>{{ round($progress) }}%</small>
        </div>

        <div class="mt-2">

            @if($d->status_validasi=='valid')
            <span class="badge bg-success">Valid</span>

            @elseif($d->status_validasi=='pending')
            <span class="badge bg-warning text-dark">Pending</span>

            @else
            <span class="badge bg-danger">Ditolak</span>
            @endif

        </div>

        <div class="mt-3 d-flex gap-2">

            <a href="/pemimpin/wilayah/{{ $d->id }}" class="btn btn-primary w-50 btn-sm">
                Detail
            </a>

            @if($d->latitude && $d->longitude)
            <button onclick="showMap({{ $d->latitude }}, {{ $d->longitude }})" class="btn btn-success w-50 btn-sm">
                Map
            </button>
            @endif

        </div>

    </div>

    @endforeach

</div>

<!-- ================= MODAL MAP ================= -->
<div class="modal fade" id="mapModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Lokasi Wilayah</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div id="previewMap" style="height:400px;border-radius:10px;"></div>
            </div>

        </div>
    </div>
</div>

<script>
let previewMap;

function showMap(lat, lng) {

    let modal = new bootstrap.Modal(document.getElementById('mapModal'));
    modal.show();

    setTimeout(() => {

        if (previewMap) {
            previewMap.remove();
        }

        previewMap = L.map('previewMap').setView([lat, lng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19
        }).addTo(previewMap);

        L.marker([lat, lng]).addTo(previewMap);

    }, 300);
}
</script>

@endsection