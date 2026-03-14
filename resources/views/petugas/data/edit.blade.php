@extends('layouts.petugas')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="fw-bold mb-0">
        <i class="fa fa-edit me-2"></i>
        Edit Data Wilayah
    </h4>

    <a href="/petugas/data" class="btn btn-light border">
        <i class="fa fa-arrow-left"></i>
        Kembali
    </a>

</div>


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form method="POST" action="/petugas/data/update/{{ $data->id }}" enctype="multipart/form-data">

            @csrf

            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Nama Wilayah</label>
                    <input type="text" name="nama_wilayah" value="{{ $data->nama_wilayah }}" class="form-control"
                        required>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Jenis Data</label>
                    <input type="text" name="jenis_data" value="{{ $data->jenis_data }}" class="form-control" required>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Target</label>
                    <input type="number" name="target" value="{{ $data->target }}" class="form-control" required>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Realisasi</label>
                    <input type="number" name="nilai_data" value="{{ $data->nilai_data }}" class="form-control"
                        required>
                </div>


                <div class="col-md-12 mb-3">
                    <label class="form-label fw-semibold">Kendala</label>
                    <textarea name="kendala" class="form-control">{{ $data->kendala }}</textarea>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal_input" value="{{ $data->tanggal_input }}" class="form-control"
                        required>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Tambah Foto Dokumentasi</label>
                    <input type="file" name="foto_dokumentasi[]" multiple class="form-control">
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Latitude</label>
                    <input type="text" id="latitude" name="latitude" value="{{ $data->latitude }}" class="form-control"
                        readonly>
                </div>


                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Longitude</label>
                    <input type="text" id="longitude" name="longitude" value="{{ $data->longitude }}"
                        class="form-control" readonly>
                </div>


                <div class="col-md-12 mb-3">

                    <button type="button" onclick="getLocation()" class="btn btn-primary">

                        <i class="fa fa-map-marker"></i>
                        Ambil Lokasi GPS

                    </button>

                </div>


                <div class="col-md-12 mb-3">

                    <label class="form-label fw-semibold">Lokasi Peta</label>

                    <div id="map" style="height:300px;border-radius:8px;"></div>

                </div>

            </div>


            <button class="btn btn-dark mt-3">
                <i class="fa fa-save"></i> Update Data
            </button>

        </form>

    </div>

</div>


<script>
let map;
let marker;


function initMap() {

    let lat = document.getElementById("latitude").value || -2.5489;
    let lng = document.getElementById("longitude").value || 118.0149;

    map = L.map('map').setView([lat, lng], 6);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);


    marker = L.marker([lat, lng]).addTo(map);


    map.on('click', function(e) {

        let lat = e.latlng.lat;
        let lng = e.latlng.lng;

        document.getElementById("latitude").value = lat;
        document.getElementById("longitude").value = lng;

        marker.setLatLng([lat, lng]);

    });

}


function getLocation() {

    if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(function(position) {

            let lat = position.coords.latitude;
            let lng = position.coords.longitude;

            document.getElementById("latitude").value = lat;
            document.getElementById("longitude").value = lng;

            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 15);

        });

    }

}


window.onload = function() {

    initMap();

}
</script>

@endsection