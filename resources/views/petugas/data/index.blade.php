@extends('layouts.petugas')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h4 class="fw-bold mb-0">
        <i class="fa fa-database me-2"></i>
        Data Wilayah
    </h4>

    <a href="/petugas/data/create" class="btn btn-dark shadow-sm">
        <i class="fa fa-plus me-1"></i>
        Tambah Data
    </a>

</div>

<!-- ================= DESKTOP TABLE ================= -->
<div class="card shadow-sm d-none d-md-block">
    <div class="card-body p-0">

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th>Wilayah</th>
                        <th>Jenis</th>
                        <th class="text-center">Target</th>
                        <th class="text-center">Realisasi</th>
                        <th width="150">Progress</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data as $d)
                    @php
                    $progress = $d->progress ?? 0;
                    $color = 'bg-danger';
                    if($progress >= 70) $color = 'bg-success';
                    elseif($progress >= 40) $color = 'bg-warning';
                    @endphp

                    <tr>

                        <td class="text-center">{{ $loop->iteration }}</td>

                        <td class="fw-semibold text-truncate" style="max-width:150px;">
                            {{ $d->nama_wilayah }}
                        </td>

                        <td>
                            <span class="badge bg-secondary">
                                {{ $d->jenis_data }}
                            </span>
                        </td>

                        <td class="text-center">{{ $d->target }}</td>
                        <td class="text-center">{{ $d->nilai_data }}</td>

                        <td>
                            <div class="progress">
                                <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%"></div>
                            </div>
                            <small>{{ round($progress,1) }}%</small>
                        </td>

                        <td>
                            @if($d->status_validasi == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($d->status_validasi == 'valid')
                            <span class="badge bg-success">Valid</span>
                            @else
                            <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="/petugas/data/edit/{{ $d->id }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button onclick="deleteData('{{ $d->id }}')" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>

                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

    </div>
</div>

<!-- ================= MOBILE CARD ================= -->
<div class="d-md-none">

    @foreach($data as $d)
    @php
    $progress = $d->progress ?? 0;
    $color = 'bg-danger';
    if($progress >= 70) $color = 'bg-success';
    elseif($progress >= 40) $color = 'bg-warning';
    @endphp

    <div class="mobile-card shadow-sm p-3 mb-3">

        <!-- TITLE -->
        <div class="fw-bold mb-1">
            {{ $d->nama_wilayah }}
        </div>

        <!-- JENIS -->
        <div class="mb-2">
            <span class="badge bg-secondary">
                {{ $d->jenis_data }}
            </span>
        </div>

        <!-- DATA -->
        <div class="small text-muted mb-2">
            Target: <b>{{ $d->target }}</b> |
            Realisasi: <b>{{ $d->nilai_data }}</b>
        </div>

        <!-- PROGRESS -->
        <div class="progress mb-1">
            <div class="progress-bar {{ $color }}" style="width: {{ $progress }}%"></div>
        </div>
        <small class="fw-semibold">{{ round($progress,1) }}%</small>

        <!-- STATUS -->
        <div class="mt-2">
            @if($d->status_validasi == 'pending')
            <span class="badge bg-warning text-dark">Pending</span>
            @elseif($d->status_validasi == 'valid')
            <span class="badge bg-success">Valid</span>
            @else
            <span class="badge bg-danger">Ditolak</span>
            @endif
        </div>

        <!-- ACTION -->
        <div class="mt-3 d-flex gap-2">
            <a href="/petugas/data/edit/{{ $d->id }}" class="btn btn-sm btn-warning w-50">
                Edit
            </a>

            <button onclick="deleteData('{{ $d->id }}')" class="btn btn-sm btn-danger w-50">
                Hapus
            </button>
        </div>

    </div>

    @endforeach

</div>

<script>
function deleteData(id) {

    Swal.fire({
        title: 'Hapus data?',
        text: 'Data tidak bisa dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Ya Hapus'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/petugas/data/delete/" + id
        }
    });

}
</script>

@endsection