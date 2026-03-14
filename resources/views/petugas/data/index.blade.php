@extends('layouts.petugas')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
/* MOBILE RESPONSIVE */

@media(max-width:768px) {

    .table {
        font-size: 13px;
    }

    .table th,
    .table td {
        padding: 8px;
    }

    .badge {
        font-size: 11px;
        padding: 4px 6px;
    }

    .progress {
        height: 6px;
    }

    .btn {
        font-size: 12px;
        padding: 4px 6px;
    }

    img {
        width: 35px !important;
        height: 35px !important;
    }

}

/* POTONG TEXT PANJANG */

.text-truncate-custom {
    max-width: 140px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
}
</style>


<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="fw-bold mb-0">
        <i class="fa fa-database me-2"></i>
        Data Wilayah
    </h4>

    <a href="/petugas/data/create" class="btn btn-dark">
        <i class="fa fa-plus me-1"></i>
        Tambah Data
    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="50">No</th>
                        <th>Wilayah</th>
                        <th>Jenis Data</th>

                        <th class="text-center">Target</th>
                        <th class="text-center">Realisasi</th>

                        <th width="150">Progress</th>

                        <th>Kendala</th>
                        <th>Dokumentasi</th>
                        <th>Lokasi</th>
                        <th>Status</th>

                        <th class="text-center">Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($data as $d)

                    <tr>

                        <td class="text-center fw-semibold">
                            {{ $loop->iteration }}
                        </td>


                        <td class="fw-semibold text-truncate-custom" title="{{ $d->nama_wilayah }}">
                            {{ $d->nama_wilayah }}
                        </td>


                        <td>

                            <span class="badge bg-secondary text-truncate-custom" title="{{ $d->jenis_data }}">

                                {{ $d->jenis_data }}

                            </span>

                        </td>


                        <td class="text-center">
                            {{ $d->target }}
                        </td>


                        <td class="text-center">
                            {{ $d->nilai_data }}
                        </td>


                        <td>

                            @php

                            $progress = $d->progress ?? 0;

                            $color = 'bg-danger';

                            if($progress >= 70){
                            $color = 'bg-success';
                            }elseif($progress >= 40){
                            $color = 'bg-warning';
                            }

                            @endphp

                            <div class="progress">

                                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%">

                                </div>

                            </div>

                            <small class="fw-semibold">
                                {{ round($progress,1) }}%
                            </small>

                        </td>


                        <td>

                            @if($d->kendala)

                            <span class="badge bg-warning text-dark text-truncate-custom" title="{{ $d->kendala }}">

                                {{ $d->kendala }}

                            </span>

                            @else

                            <span class="badge bg-success">
                                Tidak Ada
                            </span>

                            @endif

                        </td>


                        <td>

                            @if($d->foto_dokumentasi)

                            <div class="d-flex gap-1 flex-wrap">

                                @foreach($d->foto_dokumentasi as $foto)

                                <img src="{{ asset('storage/'.$foto) }}" width="45" height="45"
                                    style="object-fit:cover;border-radius:6px;border:1px solid #ddd">

                                @endforeach

                            </div>

                            @endif

                        </td>


                        <td>

                            @if(!empty($d->latitude) && !empty($d->longitude))

                            <div class="d-flex gap-1">

                                <a href="https://maps.google.com/?q={{ $d->latitude }},{{ $d->longitude }}"
                                    target="_blank" class="btn btn-sm btn-outline-primary">

                                    <i class="fa fa-map-marker"></i>

                                </a>

                                <button class="btn btn-sm btn-outline-success"
                                    onclick="showMap({{ $d->latitude }}, {{ $d->longitude }})">

                                    <i class="fa fa-map"></i>

                                </button>

                            </div>

                            @else

                            <span class="text-muted">-</span>

                            @endif

                        </td>


                        <td>

                            @if($d->status_validasi == 'pending')

                            <span class="badge bg-warning text-dark">
                                <i class="fa fa-clock"></i> Pending
                            </span>

                            @elseif($d->status_validasi == 'valid')

                            <span class="badge bg-success">
                                <i class="fa fa-check"></i> Valid
                            </span>

                            @else

                            <span class="badge bg-danger">
                                <i class="fa fa-times"></i> Ditolak
                            </span>

                            @endif

                        </td>


                        <td class="text-center">

                            <a href="/petugas/data/edit/{{ $d->id }}" class="btn btn-sm btn-outline-warning">

                                <i class="fa fa-edit"></i>

                            </a>

                            <button class="btn btn-sm btn-outline-danger" onclick="deleteData('{{ $d->id }}')">

                                <i class="fa fa-trash"></i>

                            </button>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>


<!-- MODAL MAP -->

<div class="modal fade" id="mapModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Lokasi Wilayah
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body">

                <div id="previewMap" style="height:400px;border-radius:8px;"></div>

            </div>

        </div>

    </div>

</div>


<script>
let previewMap;
let marker;

function showMap(lat, lng) {

    const modal = new bootstrap.Modal(
        document.getElementById('mapModal')
    );

    modal.show();

    setTimeout(function() {

        if (previewMap) {
            previewMap.remove();
        }

        previewMap = L.map('previewMap')
            .setView([lat, lng], 15);

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19
            }
        ).addTo(previewMap);

        marker = L.marker([lat, lng]).addTo(previewMap);

    }, 300);

}


function deleteData(id) {

    Swal.fire({

        title: 'Hapus data?',
        text: 'Data yang dihapus tidak bisa dikembalikan',
        icon: 'warning',

        showCancelButton: true,
        confirmButtonColor: '#d33',

        cancelButtonText: 'Batal',
        confirmButtonText: 'Ya Hapus'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "/petugas/data/delete/" + id

        }

    })

}
</script>

@endsection