@extends('layouts.pemimpin')

@section('content')

<h3 class="mb-4">Dashboard Pemimpin</h3>

<div class="row g-3">

    <div class="col-lg-3 col-md-6 col-12">
        <div class="card shadow text-center bg-primary text-white">
            <div class="card-body">
                <h6>Total Data</h6>
                <h2>{{ $total }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="card shadow text-center bg-success text-white">
            <div class="card-body">
                <h6>Valid</h6>
                <h2>{{ $valid }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="card shadow text-center bg-warning">
            <div class="card-body">
                <h6>Pending</h6>
                <h2>{{ $pending }}</h2>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-12">
        <div class="card shadow text-center bg-danger text-white">
            <div class="card-body">
                <h6>Ditolak</h6>
                <h2>{{ $ditolak }}</h2>
            </div>
        </div>
    </div>

</div>


<div class="row mt-4 g-3">

    <div class="col-lg-6 col-12">

        <div class="card shadow">
            <div class="card-header fw-bold">
                📈 Progress Kecamatan
            </div>

            <div class="card-body">
                <canvas id="kecamatanChart"></canvas>
            </div>

        </div>

    </div>


    <div class="col-lg-6 col-12">

        <div class="card shadow">

            <div class="card-header fw-bold">
                📉 Trend Pembangunan Wilayah
            </div>

            <div class="card-body">
                <canvas id="trendChart"></canvas>
            </div>

        </div>

    </div>

</div>


<div class="row mt-4 g-3">

    <div class="col-lg-6 col-12">

        <div class="card shadow">

            <div class="card-header fw-bold">
                🏆 Ranking Wilayah
            </div>

            <div class="card-body p-0">

                <table class="table table-striped mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>No</th>
                            <th>Wilayah</th>
                            <th>Progress</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($ranking as $r)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $r->nama_wilayah }}</td>
                            <td>{{ round($r->progress) }}%</td>
                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>


    <div class="col-lg-6 col-12">

        <div class="card shadow border-danger">

            <div class="card-header bg-danger text-white fw-bold">
                🚨 Wilayah Progress Rendah
            </div>

            <div class="card-body">

                @foreach($alert as $a)

                <div class="mb-2">

                    <b>{{ $a->nama_wilayah }}</b>

                    <div class="progress">

                        <div class="progress-bar bg-danger" style="width: {{ $a->progress }}%">

                            {{ round($a->progress) }}%

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

    </div>

</div>


<div class="row mt-4 g-3">

    <div class="col-lg-6 col-12">

        <div class="card shadow">

            <div class="card-header fw-bold">
                🔥 Heatmap Progress Wilayah
            </div>

            <div class="card-body">

                <canvas id="heatmapChart"></canvas>

            </div>

        </div>

    </div>


    <div class="col-lg-6 col-12">

        <div class="card shadow">

            <div class="card-header fw-bold">
                🗺️ Peta Monitoring Wilayah
            </div>

            <div class="card-body">

                <div id="map" style="height:350px"></div>

            </div>

        </div>

    </div>

</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const wilayahData = @json($wilayah);
const trendData = @json($trend);

new Chart(document.getElementById('kecamatanChart'), {
    type: 'bar',
    data: {
        labels: wilayahData.map(w => w.nama_wilayah),
        datasets: [{
            data: wilayahData.map(w => w.progress),
            backgroundColor: '#0d6efd'
        }]
    }
});

new Chart(document.getElementById('trendChart'), {
    type: 'line',
    data: {
        labels: trendData.map(t => 'Bulan ' + t.bulan),
        datasets: [{
            data: trendData.map(t => t.progress),
            borderColor: '#28a745',
            backgroundColor: 'rgba(40,167,69,0.2)',
            fill: true
        }]
    }
});

new Chart(document.getElementById('heatmapChart'), {
    type: 'bar',
    data: {
        labels: wilayahData.map(w => w.nama_wilayah),
        datasets: [{
            data: wilayahData.map(w => w.progress),
            backgroundColor: wilayahData.map(w => {
                if (w.progress < 40) return '#dc3545';
                if (w.progress < 70) return '#ffc107';
                return '#28a745';
            })
        }]
    }
});
</script>


<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<!-- ✅ MAP REALTIME (INI SAJA YANG BERUBAH) -->
<script>
const mapData = @json($dataMap ?? []);

// default lokasi
let lat = -0.8917;
let lng = 119.8707;

if (mapData.length) {
    lat = mapData[0].latitude;
    lng = mapData[0].longitude;
}

var map = L.map('map').setView([lat, lng], 12);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19
}).addTo(map);

// 🔥 LOOP DATA DARI DATABASE
mapData.forEach(item => {

    if (!item.latitude || !item.longitude) return;

    let color = 'green';

    if (item.progress < 40) {
        color = 'red';
    } else if (item.progress < 70) {
        color = 'orange';
    }

    let marker = L.circleMarker([item.latitude, item.longitude], {
        radius: 8,
        color: color,
        fillColor: color,
        fillOpacity: 0.8
    }).addTo(map);

    marker.bindPopup(
        "<b>" + item.nama_wilayah + "</b><br>Progress: " + Math.round(item.progress) + "%"
    );

});
</script>

@endsection