@extends('layouts.admin')

@section('content')

<style>
/* RESPONSIVE TABLE */

@media(max-width:768px) {

    .table {
        font-size: 13px;
    }

    .table th,
    .table td {
        padding: 8px;
        vertical-align: middle;
    }

    .badge {
        font-size: 11px;
        padding: 4px 6px;
    }

    .progress {
        height: 16px;
    }

    .btn {
        padding: 4px 6px;
        font-size: 12px;
    }

    .export-btn {
        width: 100%;
        margin-bottom: 5px;
    }

}

/* POTONG TEXT PANJANG */

.text-truncate-custom {
    max-width: 150px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: inline-block;
}
</style>


<div class="card shadow-sm">

    <div class="card-header">

        <h5 class="text-primary mb-0">

            <i class="fa fa-file-lines"></i>
            Rekap Seluruh Laporan

        </h5>

    </div>


    <div class="card-body">

        <div class="table-responsive">


            <div class="mb-3 d-flex flex-wrap gap-2">

                <a href="/admin/laporan/pdf" class="btn btn-danger export-btn">

                    <i class="fa fa-file-pdf"></i>
                    Export PDF

                </a>

                <a href="/admin/laporan/excel" class="btn btn-success export-btn">

                    <i class="fa fa-file-excel"></i>
                    Export Excel

                </a>

            </div>



            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th width="60">No</th>
                        <th>Petugas</th>
                        <th>Wilayah</th>
                        <th style="max-width:160px">Jenis Data</th>
                        <th style="width:150px">Progress</th>
                        <th>Status</th>
                        <th style="width:120px">Aksi</th>

                    </tr>

                </thead>


                <tbody>

                    @foreach($data as $d)

                    <tr>

                        <td>{{ $loop->iteration }}</td>


                        <td>
                            {{ $d->petugas->name }}
                        </td>


                        <td>
                            {{ $d->nama_wilayah }}
                        </td>


                        <td style="max-width:160px">

                            <span class="badge bg-info text-truncate-custom" title="{{ $d->jenis_data }}">

                                {{ $d->jenis_data }}

                            </span>

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


                        <td>

                            @if($d->status_validasi == 'pending')

                            <span class="badge bg-warning text-dark">
                                Pending
                            </span>

                            @elseif($d->status_validasi == 'valid')

                            <span class="badge bg-success">
                                Valid
                            </span>

                            @else

                            <span class="badge bg-danger">
                                Ditolak
                            </span>

                            @endif

                        </td>


                        <td>

                            <div class="d-flex gap-1">

                                <a href="/admin/laporan/detail/{{ $d->id }}" class="btn btn-sm btn-primary">

                                    <i class="fa fa-eye"></i>

                                </a>


                                <button onclick="deleteData('{{ $d->id }}')" class="btn btn-sm btn-danger">

                                    <i class="fa fa-trash"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>



<script>
function deleteData(id) {

    Swal.fire({

        title: 'Hapus laporan?',
        text: 'Data yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "/admin/laporan/delete/" + id

        }

    })

}
</script>

@endsection