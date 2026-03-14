@extends('layouts.pemimpin')

@section('content')

<style>
/* MOBILE RESPONSIVE */

@media(max-width:768px) {

    .table thead {
        display: none;
    }

    .table,
    .table tbody,
    .table tr,
    .table td {
        display: block;
        width: 100%;
    }

    .table tr {
        background: #fff;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }

    /* FIELD ROW */

    .table td {
        border: none;
        padding: 6px 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    /* LABEL */

    .table td::before {
        font-weight: 600;
        color: #555;
        min-width: 90px;
    }

    /* LABEL TEXT */

    .table td:nth-child(1)::before {
        content: "No";
    }

    .table td:nth-child(2)::before {
        content: "Petugas";
    }

    .table td:nth-child(3)::before {
        content: "Wilayah";
    }

    .table td:nth-child(4)::before {
        content: "Jenis";
    }

    .table td:nth-child(5)::before {
        content: "Progress";
    }

    .table td:nth-child(6)::before {
        content: "Tanggal";
    }

    .table td:nth-child(7)::before {
        content: "Aksi";
    }

    /* PROGRESS FIX */

    .progress {
        flex: 1;
        margin-left: 10px;
        height: 16px;
    }

    /* BUTTON */

    .table td:last-child {
        justify-content: flex-end;
    }

    /* EXPORT BUTTON */

    .export-wrap {
        flex-direction: column;
        gap: 10px;
        align-items: flex-start !important;
    }

}
</style>



<h3 class="mb-4">Laporan Wilayah</h3>

<div class="card shadow-sm">

    <div class="card-body">


        <!-- EXPORT BUTTON -->

        <div class="d-flex justify-content-between align-items-center mb-3 export-wrap">

            <div class="dropdown">

                <button class="btn btn-danger dropdown-toggle" type="button" data-bs-toggle="dropdown">

                    <i class="fa fa-file-pdf"></i>
                    Cetak PDF

                </button>

                <ul class="dropdown-menu">

                    <li>
                        <a class="dropdown-item" href="/pemimpin/laporan/pdf?type=a4p">
                            A4 Portrait
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/pemimpin/laporan/pdf?type=a4l">
                            A4 Landscape
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/pemimpin/laporan/pdf?type=f4p">
                            F4 Portrait
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item" href="/pemimpin/laporan/pdf?type=f4l">
                            F4 Landscape
                        </a>
                    </li>

                </ul>

            </div>


            <a href="/pemimpin/laporan/excel" class="btn btn-success">

                <i class="fa fa-file-excel"></i>
                Export Excel

            </a>

        </div>


        <!-- TABLE -->

        <div class="table-responsive">

            <table class="table table-bordered table-hover">

                <thead class="table-light text-center">

                    <tr>

                        <th>No</th>
                        <th>Petugas</th>
                        <th>Wilayah</th>
                        <th>Jenis Data</th>
                        <th>Progress</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($data as $d)

                    <tr>

                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $d->petugas->name }}</td>

                        <td>{{ $d->nama_wilayah }}</td>

                        <td>{{ $d->jenis_data }}</td>


                        <td>

                            @php

                            $progress=$d->progress ?? 0;

                            $color='bg-danger';

                            if($progress>=70){
                            $color='bg-success';
                            }elseif($progress>=40){
                            $color='bg-warning';
                            }

                            @endphp

                            <div class="progress">

                                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%">

                                    {{ round($progress) }}%

                                </div>

                            </div>

                        </td>


                        <td>{{ $d->tanggal_input }}</td>


                        <td>

                            <a href="/pemimpin/wilayah/{{ $d->id }}" class="btn btn-primary btn-sm">

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7" class="text-center text-muted">

                            Tidak ada data laporan

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection