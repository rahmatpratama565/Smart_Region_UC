@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white border-bottom">

            <h5 class="mb-0 text-primary">

                <i class="fa fa-file-lines me-2"></i>
                Detail Laporan Wilayah

            </h5>

        </div>



        <div class="card-body">

            <div class="row g-4">

                {{-- INFORMASI DATA --}}

                <div class="col-md-6">

                    <div class="card border-0 bg-light">

                        <div class="card-body">

                            <h6 class="text-secondary mb-3">

                                <i class="fa fa-info-circle"></i>
                                Informasi Laporan

                            </h6>

                            <table class="table table-sm table-borderless">

                                <tr>
                                    <td width="150"><b>Petugas</b></td>
                                    <td>: {{ $data->petugas->name }}</td>
                                </tr>

                                <tr>
                                    <td><b>Wilayah</b></td>
                                    <td>: {{ $data->nama_wilayah }}</td>
                                </tr>

                                <tr>
                                    <td><b>Jenis Data</b></td>
                                    <td>: {{ $data->jenis_data }}</td>
                                </tr>

                                <tr>
                                    <td><b>Tanggal</b></td>
                                    <td>: {{ $data->tanggal_input }}</td>
                                </tr>

                            </table>

                        </div>
                    </div>

                </div>



                {{-- TARGET DATA --}}

                <div class="col-md-6">

                    <div class="card border-0 bg-light">

                        <div class="card-body">

                            <h6 class="text-secondary mb-3">

                                <i class="fa fa-chart-bar"></i>
                                Target & Realisasi

                            </h6>

                            <table class="table table-sm table-borderless">

                                <tr>
                                    <td width="150"><b>Target</b></td>
                                    <td>: {{ $data->target }}</td>
                                </tr>

                                <tr>
                                    <td><b>Realisasi</b></td>
                                    <td>: {{ $data->nilai_data }}</td>
                                </tr>

                                <tr>
                                    <td><b>Progress</b></td>

                                    <td>

                                        <div class="progress" style="height:20px">

                                            <div class="progress-bar bg-success" style="width: {{ $data->progress }}%">

                                                {{ round($data->progress) }}%

                                            </div>

                                        </div>

                                    </td>

                                </tr>

                            </table>

                        </div>
                    </div>

                </div>



                {{-- KENDALA --}}

                <div class="col-md-12">

                    <div class="card border-0 bg-light">

                        <div class="card-body">

                            <h6 class="text-secondary mb-3">

                                <i class="fa fa-triangle-exclamation"></i>
                                Kendala Lapangan

                            </h6>

                            <p class="mb-0 text-muted">

                                {{ $data->kendala ?? 'Tidak ada kendala yang dilaporkan.' }}

                            </p>

                        </div>
                    </div>

                </div>



                {{-- FOTO DOKUMENTASI --}}

                @if($data->foto_dokumentasi)

                <div class="col-md-12">

                    <div class="card border-0 bg-light">

                        <div class="card-body">

                            <h6 class="text-secondary mb-3">

                                <i class="fa fa-image"></i>
                                Dokumentasi Lapangan

                            </h6>

                            <div class="row g-3">

                                @foreach($data->foto_dokumentasi as $foto)

                                <div class="col-md-3">

                                    <img src="{{ asset('storage/'.$foto) }}" class="img-fluid rounded shadow-sm">

                                </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                </div>

                @endif


            </div>



            <hr class="mt-4">

            <div class="d-flex justify-content-between">

                <a href="/admin/laporan" class="btn btn-outline-secondary">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>

            </div>



        </div>

    </div>

</div>

@endsection