<!DOCTYPE html>
<html>

<head>

    <title>Smart Region UC</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <style>
    body {
        background: #f5f7fb;
        font-family: 'Segoe UI', sans-serif;
    }

    /* HERO */

    .hero {
        padding: 90px 20px;
        text-align: center;
        background: linear-gradient(135deg, #0d6efd, #4dabff);
        color: white;
    }

    .hero h1 {
        font-weight: 700;
    }

    /* SECTION */

    .section {
        padding: 70px 0;
    }

    /* CARD */

    .card {
        border: none;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: .3s;
    }

    .card:hover {
        transform: translateY(-4px);
    }

    /* STAT */

    .stat-card {
        background: white;
        padding: 25px;
        text-align: center;
    }

    .stat-number {
        font-size: 34px;
        font-weight: 700;
    }

    /* MAP */

    #map {
        height: 450px;
        border-radius: 14px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    /* GALLERY */

    .gallery img {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 10px;
        transition: .3s;
    }

    .gallery img:hover {
        transform: scale(1.05);
    }

    /* MOBILE */

    @media(max-width:768px) {

        .hero {
            padding: 60px 20px;
        }

        .stat-number {
            font-size: 26px;
        }

        .section {
            padding: 40px 0;
        }

    }
    </style>

</head>

<body>



    <!-- HERO -->

    <div class="hero">

        <div class="container">

            <h1>Smart Region UC</h1>

            <p>Sistem Monitoring Data Wilayah</p>

            <div class="mt-3">

                <a href="/petugas/login" class="btn btn-outline-light btn-sm me-2">Petugas</a>

                <a href="/pemimpin/login" class="btn btn-outline-light btn-sm">Pemimpin</a>

            </div>

        </div>

    </div>



    <!-- STATISTIK -->

    <div class="section">

        <div class="container">

            <h3 class="text-center mb-5 fw-bold">Beranda Utama</h3>

            <div class="row text-center g-4">


                <div class="col-6 col-md-3">
                    <div class="card stat-card">
                        <div class="stat-number text-primary">{{ $total }}</div>
                        <p class="text-muted mb-0">Total Data</p>
                    </div>
                </div>


                <div class="col-6 col-md-3">
                    <div class="card stat-card">
                        <div class="stat-number text-success">{{ $valid }}</div>
                        <p class="text-muted mb-0">Valid</p>
                    </div>
                </div>


                <div class="col-6 col-md-3">
                    <div class="card stat-card">
                        <div class="stat-number text-warning">{{ $pending }}</div>
                        <p class="text-muted mb-0">Pending</p>
                    </div>
                </div>


                <div class="col-6 col-md-3">
                    <div class="card stat-card">
                        <div class="stat-number text-danger">{{ $ditolak }}</div>
                        <p class="text-muted mb-0">Ditolak</p>
                    </div>
                </div>


            </div>

        </div>

    </div>



    <!-- CHART -->

    <div class="section bg-white">

        <div class="container">

            <div class="row g-4">

                <div class="col-lg-6">

                    <div class="card p-4">

                        <h5 class="fw-semibold mb-3">Status Data Wilayah</h5>

                        <canvas id="statusChart"></canvas>

                    </div>

                </div>


                <div class="col-lg-6">

                    <div class="card p-4">

                        <h5 class="fw-semibold mb-3">Perkembangan Bulanan</h5>

                        <canvas id="monthlyChart"></canvas>

                    </div>

                </div>

            </div>

        </div>

    </div>



    <!-- MAP -->

    <div class="section">

        <div class="container">

            <h3 class="text-center mb-5 fw-bold">

                Peta Monitoring Wilayah

            </h3>

            <div id="map"></div>

        </div>

    </div>



    <!-- RANKING -->

    <div class="section">

        <div class="container">

            <h3 class="text-center mb-5 fw-bold">Ranking Wilayah Terbaik</h3>

            <div class="card p-4">

                <table class="table table-hover text-center">

                    <thead class="table-primary">

                        <tr>
                            <th>Rank</th>
                            <th>Wilayah</th>
                            <th>Progress</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach($ranking as $index => $r)

                        <tr>

                            <td>

                                @if($index==0)
                                🥇
                                @elseif($index==1)
                                🥈
                                @elseif($index==2)
                                🥉
                                @else
                                {{ $index+1 }}
                                @endif

                            </td>

                            <td>{{ $r->nama_wilayah }}</td>

                            <td>

                                <div class="progress">

                                    <div class="progress-bar bg-primary" style="width: {{ $r->progress }}%">

                                        {{ round($r->progress) }}%

                                    </div>

                                </div>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>



    <!-- GALERI -->

    <div class="section bg-white">

        <div class="container">

            <h3 class="text-center mb-5 fw-bold">Dokumentasi Wilayah</h3>

            <div class="row g-4 gallery">

                @foreach($fotos as $foto)

                @if($foto->foto_dokumentasi)

                @foreach($foto->foto_dokumentasi as $img)

                <div class="col-6 col-md-4">

                    <img src="{{ asset('storage/'.$img) }}">

                </div>

                @endforeach

                @endif

                @endforeach

            </div>

        </div>

    </div>



    <script>
    const statusData = @json([$pending, $valid, $ditolak]);

    new Chart(document.getElementById("statusChart"), {

        type: 'doughnut',

        data: {
            labels: ['Pending', 'Valid', 'Ditolak'],
            datasets: [{
                data: statusData,
                backgroundColor: ['#ffc107', '#198754', '#dc3545']
            }]
        },

        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }

    });
    </script>



    <script>
    const monthlyData = @json($monthlyData);

    const labels = monthlyData.map(x => "Bulan " + x.bulan);

    const values = monthlyData.map(x => x.total);

    new Chart(document.getElementById("monthlyChart"), {

        type: 'line',

        data: {
            labels: labels,
            datasets: [{
                label: 'Data Wilayah',
                data: values,
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)',
                fill: true,
                tension: .4
            }]
        }

    });
    </script>



    <script>
    const map = L.map('map').setView([-0.9, 119.87], 11);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19
    }).addTo(map);

    const wilayah = @json($mapData);

    wilayah.forEach(function(item) {

        if (item.latitude && item.longitude) {

            L.marker([item.latitude, item.longitude])

                .addTo(map)

                .bindPopup(

                    "<b>" + item.nama_wilayah + "</b><br>Progress: " + Math.round(item.progress) + "%"

                );

        }

    });
    </script>

</body>

</html>