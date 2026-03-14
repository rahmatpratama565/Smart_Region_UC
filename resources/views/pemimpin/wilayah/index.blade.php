@extends('layouts.pemimpin')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<h3 class="mb-4">Monitoring Wilayah</h3>

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        Data Monitoring Wilayah
    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-light text-center">

                    <tr>
                        <th width="5%">No</th>
                        <th>Petugas</th>
                        <th>Wilayah</th>
                        <th width="25%">Progress</th>
                        <th width="15%">Lokasi</th>
                        <th width="15%">Status</th>
                        <th width="10%">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($data as $d)

                    <tr>

                        <td class="text-center">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            {{ $d->petugas->name }}
                        </td>

                        <td>
                            {{ $d->nama_wilayah }}
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

                        <td class="text-center">

                            @if($d->latitude && $d->longitude)

                            <div class="d-flex justify-content-center gap-1">

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


                        <td class="text-center">

                            @if($d->status_validasi == 'valid')

                            <span class="badge bg-success">
                                Valid
                            </span>

                            @elseif($d->status_validasi == 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                            @else

                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                            @endif

                        </td>


                        <td class="text-center">

                            <a href="/pemimpin/wilayah/{{ $d->id }}" class="btn btn-primary btn-sm">

                                <i class="fa fa-eye"></i> Detail

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
</script>

@endsection