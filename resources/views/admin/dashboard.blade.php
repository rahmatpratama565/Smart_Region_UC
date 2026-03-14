@extends('layouts.admin')

@section('content')

<h2 class="mb-4">Dashboard Admin</h2>

@include('admin.partials.widgets')


<div class="row g-3 mb-4">

    <div class="col-lg-6 col-12">
        <div class="card shadow h-100">

            <div class="card-header">
                Status Validasi Data
            </div>

            <div class="card-body">

                <div class="chart-box">
                    <canvas id="statusChart"></canvas>
                </div>

            </div>

        </div>
    </div>


    <div class="col-lg-6 col-12">
        <div class="card shadow h-100">

            <div class="card-header">
                Statistik User
            </div>

            <div class="card-body">

                <div class="chart-box">
                    <canvas id="userChart"></canvas>
                </div>

            </div>

        </div>
    </div>

</div>



{{-- PROGRESS WILAYAH TOTAL --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Progress Wilayah (Rata-rata)
    </div>

    <div class="card-body">

        @php

        $color = 'bg-danger';

        if($avgProgress >= 70){
        $color = 'bg-success';
        }elseif($avgProgress >= 40){
        $color = 'bg-warning';
        }

        @endphp

        <div class="progress progress-big">

            <div class="progress-bar {{ $color }}" style="width: {{ $avgProgress }}%">

                {{ number_format($avgProgress,1) }} %

            </div>

        </div>

    </div>

</div>



{{-- PROGRESS PER WILAYAH --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Progress Wilayah per Kecamatan
    </div>

    <div class="card-body">

        @foreach($progressWilayah as $w)

        @php

        $color = 'bg-danger';

        if($w->progress >= 70){
        $color = 'bg-success';
        }elseif($w->progress >= 40){
        $color = 'bg-warning';
        }

        @endphp

        <div class="mb-3">

            <strong>{{ $w->nama_wilayah }}</strong>

            <div class="progress">

                <div class="progress-bar {{ $color }}" style="width: {{ $w->progress }}%">

                    {{ number_format($w->progress,1) }} %

                </div>

            </div>

        </div>

        @endforeach

    </div>

</div>



{{-- RANKING WILAYAH TERBAIK --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Ranking Kecamatan Terbaik
    </div>

    <div class="card-body table-responsive">

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Kecamatan</th>
                    <th>Progress</th>
                </tr>
            </thead>

            <tbody>

                @foreach($rankingWilayah as $index => $r)

                @php

                $color = 'bg-danger';

                if($r->progress >= 70){
                $color = 'bg-success';
                }elseif($r->progress >= 40){
                $color = 'bg-warning';
                }

                @endphp

                <tr>

                    <td>{{ $index + 1 }}</td>

                    <td>{{ $r->nama_wilayah }}</td>

                    <td>

                        <div class="progress">

                            <div class="progress-bar {{ $color }}" style="width: {{ $r->progress }}%">

                                {{ number_format($r->progress,1) }} %

                            </div>

                        </div>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>



{{-- GRAFIK WILAYAH --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Grafik Wilayah per Kecamatan
    </div>

    <div class="card-body">

        <div class="chart-large">
            <canvas id="wilayahChart"></canvas>
        </div>

    </div>

</div>



{{-- GRAFIK BULAN --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Grafik Perkembangan Data
    </div>

    <div class="card-body">

        <div class="chart-large">
            <canvas id="monthlyChart"></canvas>
        </div>

    </div>

</div>



{{-- MAP --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Peta Monitoring Wilayah
    </div>

    <div class="card-body">

        <div id="map" class="map-responsive"></div>

    </div>

</div>



{{-- BRUTE FORCE --}}

<div class="card shadow mt-4">

    <div class="card-header">
        Deteksi Brute Force Login
    </div>

    <div class="table-responsive">

        <table class="table table-striped">

            <thead>
                <tr>
                    <th>IP</th>
                    <th>Percobaan</th>
                    <th>Terakhir</th>
                </tr>
            </thead>

            <tbody>

                @foreach($bruteforce as $b)

                <tr>
                    <td>{{ $b->ip_address }}</td>
                    <td>{{ $b->total }}</td>
                    <td>{{ $b->last_attempt }}</td>
                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>



<style>
/* CHART SIZE */

.chart-box {
    height: 250px;
}

.chart-large {
    height: 320px;
}

/* MAP */

.map-responsive {
    height: 400px;
    border-radius: 8px;
}

/* PROGRESS */

.progress-big {
    height: 30px;
}

/* MOBILE */

@media(max-width:768px) {

    .chart-box {
        height: 220px;
    }

    .chart-large {
        height: 260px;
    }

    .map-responsive {
        height: 300px;
    }

    h2 {
        font-size: 20px;
    }

}
</style>



<script>
document.addEventListener("DOMContentLoaded", function() {

    const statusData = @json([$pending, $valid, $ditolak]);
    const userData = @json([$totalPetugas, $totalPemimpin]);

    const wilayahData = @json($wilayahChart ?? []);
    const monthlyData = @json($monthlyData ?? []);
    const mapData = @json($mapData ?? []);


    /* STATUS CHART */

    new Chart(document.getElementById('statusChart'), {
        type: 'pie',
        data: {
            labels: ['Pending', 'Valid', 'Ditolak'],
            datasets: [{
                data: statusData,
                backgroundColor: ['#f39c12', '#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    /* USER CHART */

    new Chart(document.getElementById('userChart'), {
        type: 'bar',
        data: {
            labels: ['Petugas', 'Pemimpin'],
            datasets: [{
                label: 'Jumlah User',
                data: userData,
                backgroundColor: ['#007bff', '#17a2b8']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    /* WILAYAH CHART */

    const wilayahLabels = wilayahData.map(w => w.nama_wilayah);
    const wilayahTotal = wilayahData.map(w => w.total);

    new Chart(document.getElementById('wilayahChart'), {
        type: 'bar',
        data: {
            labels: wilayahLabels,
            datasets: [{
                label: 'Jumlah Data',
                data: wilayahTotal,
                backgroundColor: '#17a2b8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    /* BULAN CHART */

    const bulanNama = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const bulan = monthlyData.map(m => bulanNama[m.bulan - 1]);
    const total = monthlyData.map(m => m.total);

    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: bulan,
            datasets: [{
                label: 'Data Wilayah',
                data: total,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0,123,255,0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });


    /* MAP */

    const map = L.map('map').setView([-0.8986, 119.8506], 10);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
    }).addTo(map);

    mapData.forEach(function(w) {

        if (!w.latitude || !w.longitude) return;

        let color = "blue";

        if (w.progress < 40) {
            color = "red";
        } else if (w.progress < 70) {
            color = "orange";
        } else {
            color = "green";
        }

        const icon = L.icon({
            iconUrl: `https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-${color}.png`,
            shadowUrl: 'https://unpkg.com/leaflet@1.7.1/dist/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41]
        });

        L.marker([w.latitude, w.longitude], {
                icon: icon
            })
            .addTo(map)
            .bindPopup("<b>" + w.nama_wilayah + "</b><br>Progress: " + w.progress + "%");

    });

});
</script>

@endsection