@extends('layouts.petugas')

@section('content')

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function() {

    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil',
        text: '{{ session("success") }}',
        confirmButtonColor: '#000'
    });

});
</script>

@endif
<h4 class="fw-bold mb-4">
    <i class="fa fa-chart-line me-2"></i>
    Dashboard Petugas
</h4>


<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-primary">
                    <i class="fa fa-database fa-2x"></i>
                </div>

                <div>
                    <p class="mb-1 text-muted small">Total Data</p>
                    <h4 class="fw-bold mb-0">{{ $total }}</h4>
                </div>

            </div>

        </div>

    </div>



    <div class="col-6 col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-warning">
                    <i class="fa fa-clock fa-2x"></i>
                </div>

                <div>
                    <p class="mb-1 text-muted small">Pending</p>
                    <h4 class="fw-bold mb-0">{{ $pending }}</h4>
                </div>

            </div>

        </div>

    </div>



    <div class="col-6 col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-success">
                    <i class="fa fa-check-circle fa-2x"></i>
                </div>

                <div>
                    <p class="mb-1 text-muted small">Valid</p>
                    <h4 class="fw-bold mb-0">{{ $valid }}</h4>
                </div>

            </div>

        </div>

    </div>



    <div class="col-6 col-md-3">

        <div class="card border-0 shadow-sm h-100">

            <div class="card-body d-flex align-items-center">

                <div class="me-3 text-danger">
                    <i class="fa fa-times-circle fa-2x"></i>
                </div>

                <div>
                    <p class="mb-1 text-muted small">Ditolak</p>
                    <h4 class="fw-bold mb-0">{{ $ditolak }}</h4>
                </div>

            </div>

        </div>

    </div>

</div>



<div class="row g-3">

    <div class="col-lg-6">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white fw-semibold">
                Status Data Wilayah
            </div>

            <div class="card-body">

                <div style="height:300px">

                    <canvas id="statusChart"></canvas>

                </div>

            </div>

        </div>

    </div>



    <div class="col-lg-6">

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white fw-semibold">
                Informasi Sistem
            </div>

            <div class="card-body">

                <ul class="list-group list-group-flush">

                    <li class="list-group-item d-flex justify-content-between">
                        Total Data
                        <span class="fw-semibold">{{ $total }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Data Pending
                        <span class="fw-semibold text-warning">{{ $pending }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Data Valid
                        <span class="fw-semibold text-success">{{ $valid }}</span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between">
                        Data Ditolak
                        <span class="fw-semibold text-danger">{{ $ditolak }}</span>
                    </li>

                </ul>

            </div>

        </div>

    </div>

</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const statusData = @json([
    $pending,
    $valid,
    $ditolak
]);

const ctx = document.getElementById('statusChart');

new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: ['Pending', 'Valid', 'Ditolak'],

        datasets: [{

            data: statusData,

            backgroundColor: [
                '#ffc107',
                '#28a745',
                '#dc3545'
            ]

        }]

    },

    options: {
        responsive: true,
        maintainAspectRatio: false,

        plugins: {
            legend: {
                position: 'bottom'
            }
        }

    }

});
</script>

@endsection