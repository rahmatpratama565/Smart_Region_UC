@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <div class="card shadow-lg border-0">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">

                <i class="fa fa-check-circle"></i>
                Validasi Data Wilayah

            </h5>

        </div>



        <div class="card-body">

            <div class="row g-4">

                <!-- INFORMASI DATA -->

                <div class="col-md-6">

                    <div class="card border-0 bg-light h-100">

                        <div class="card-body">

                            <h6 class="text-primary mb-3">
                                Informasi Wilayah
                            </h6>

                            <table class="table table-sm table-borderless">

                                <tr>
                                    <td width="140"><b>Petugas</b></td>
                                    <td>: {{ $data->petugas->name }}</td>
                                </tr>

                                <tr>
                                    <td><b>Wilayah</b></td>
                                    <td>: {{ $data->nama_wilayah }}</td>
                                </tr>

                                <tr>
                                    <td><b>Jenis Data</b></td>
                                    <td>

                                        <span class="badge bg-info">

                                            {{ $data->jenis_data }}

                                        </span>

                                    </td>
                                </tr>

                                <tr>
                                    <td><b>Target</b></td>
                                    <td>: {{ $data->target }}</td>
                                </tr>

                                <tr>
                                    <td><b>Realisasi</b></td>
                                    <td>: {{ $data->nilai_data }}</td>
                                </tr>

                                <tr>
                                    <td><b>Tanggal</b></td>
                                    <td>: {{ $data->tanggal_input }}</td>
                                </tr>

                            </table>

                        </div>

                    </div>

                </div>



                <!-- PROGRESS -->

                <div class="col-md-6">

                    <div class="card border-0 bg-light h-100">

                        <div class="card-body">

                            <h6 class="text-primary mb-3">
                                Progress Wilayah
                            </h6>

                            <div class="progress mb-3" style="height:28px">

                                <div class="progress-bar bg-success fw-bold" style="width: {{ $data->progress }}%">

                                    {{ round($data->progress) }}%

                                </div>

                            </div>

                            <h6 class="text-primary mt-4">
                                Kendala
                            </h6>

                            <div class="p-3 bg-white border rounded">

                                {{ $data->kendala ?? 'Tidak ada kendala' }}

                            </div>

                        </div>

                    </div>

                </div>

            </div>



            <hr>



            <!-- FOTO -->

            @if($data->foto_dokumentasi)

            <h6 class="text-primary mb-3">

                <i class="fa fa-image"></i>
                Dokumentasi Lapangan

            </h6>

            <div class="row g-3">

                @foreach($data->foto_dokumentasi as $foto)

                <div class="col-md-3">

                    <div class="card border-0 shadow-sm">

                        <img src="{{ asset('storage/'.$foto) }}" class="img-fluid rounded">

                    </div>

                </div>

                @endforeach

            </div>

            @endif



            <hr>



            <!-- TOMBOL -->

            <div class="d-flex gap-3">

                <a href="/admin/wilayah/setuju/{{ $data->id }}" class="btn btn-success px-4">

                    <i class="fa fa-check"></i>
                    Setujui

                </a>


                <a href="/admin/wilayah/tolak/{{ $data->id }}" class="btn btn-danger px-4">

                    <i class="fa fa-times"></i>
                    Tolak

                </a>


                <a href="/admin/wilayah" class="btn btn-secondary px-4">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>

            </div>



        </div>

    </div>

</div>

@endsection