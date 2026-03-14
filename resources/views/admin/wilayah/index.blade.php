@extends('layouts.admin')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<style>
/* RESPONSIVE TABLE */

@media(max-width:768px) {

    .table {
        font-size: 13px;
    }

    .table th,
    .table td {
        padding: 8px;
        vertical-align: middle;
    }

    .badge {
        font-size: 11px;
        padding: 4px 6px;
    }

    .progress {
        height: 16px;
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

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0">
            <i class="fa fa-map text-primary"></i>
            Monitoring Data Wilayah
        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>
                        <th>Petugas</th>
                        <th>Wilayah</th>
                        <th style="max-width:160px">Jenis Data</th>
                        <th style="width:140px">Progress</th>
                        <th style="width:90px">Lokasi</th>
                        <th>Status</th>
                        <th style="width:120px">Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($data as $d)

                    <tr>

                        <td class="fw-bold">
                            {{ $loop->iteration }}
                        </td>


                        <td>
                            <i class="fa fa-user text-secondary"></i>
                            {{ $d->petugas->name }}
                        </td>


                        <td>
                            <span class="fw-semibold">
                                {{ $d->nama_wilayah }}
                            </span>
                        </td>


                        <td style="max-width:160px">

                            <span class="badge bg-info text-truncate-custom" title="{{ $d->jenis_data }}">

                                {{ $d->jenis_data }}

                            </span>

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

                                    {{ round($progress) }}%

                                </div>

                            </div>

                        </td>


                        <!-- LOKASI -->

                        <td>

                            @if($d->latitude && $d->longitude)

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
                                Pending
                            </span>

                            @elseif($d->status_validasi == 'valid')

                            <span class="badge bg-success">
                                Valid
                            </span>

                            @else

                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                            @endif

                        </td>


                        <td>

                            <div class="d-flex gap-1">

                                <a href="/admin/wilayah/validasi/{{ $d->id }}" class="btn btn-sm btn-primary">

                                    <i class="fa fa-check"></i>

                                </a>


                                <button class="btn btn-sm btn-danger" onclick="deleteData('{{ $d->id }}')">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </div>

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

        marker = L.marker([lat, lng])
            .addTo(previewMap);

    }, 300);

}



function deleteData(id) {

    Swal.fire({

        title: 'Hapus Data?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "/admin/laporan/delete/" + id

        }

    })

}
</script>

@endsection