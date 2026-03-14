@extends('layouts.pemimpin')

@section('content')

<h3 class="mb-4">Detail Laporan Wilayah</h3>

<div class="card shadow-sm">

    <div class="card-header bg-primary text-white">
        Informasi Monitoring Wilayah
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Petugas</label>
                <div class="form-control bg-light">
                    {{ $data->petugas->name }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Wilayah</label>
                <div class="form-control bg-light">
                    {{ $data->nama_wilayah }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Jenis Data</label>
                <div class="form-control bg-light">
                    {{ $data->jenis_data }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Target</label>
                <div class="form-control bg-light">
                    {{ $data->target }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Realisasi</label>
                <div class="form-control bg-light">
                    {{ $data->nilai_data }}
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Tanggal Input</label>
                <div class="form-control bg-light">
                    {{ $data->tanggal_input }}
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="fw-bold">Progress</label>

                <div class="progress">

                    <div class="progress-bar bg-success" role="progressbar" style="width: {{ $data->progress }}%">

                        {{ round($data->progress) }}%

                    </div>

                </div>
            </div>

            <div class="col-md-12 mb-3">
                <label class="fw-bold">Kendala</label>

                <div class="form-control bg-light" style="height:auto">

                    {{ $data->kendala ?? 'Tidak ada kendala' }}

                </div>
            </div>

        </div>

        <hr>

        <a href="/pemimpin/wilayah" class="btn btn-secondary">
            <i class="fa fa-arrow-left"></i> Kembali
        </a>

    </div>

</div>

@endsection