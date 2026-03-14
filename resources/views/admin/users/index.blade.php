@extends('layouts.admin')

@section('content')

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h5 class="mb-0 text-primary">
            <i class="fa fa-users"></i>
            Manajemen Akun
        </h5>

        <a href="/admin/users/create" class="btn btn-primary">
            <i class="fa fa-user-plus"></i>
            Tambah Akun
        </a>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th width="200">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($users as $u)

                    <tr>

                        <td class="fw-bold">
                            {{ $loop->iteration }}
                        </td>

                        <td>
                            <i class="fa fa-user text-secondary"></i>
                            {{ $u->name }}
                        </td>

                        <td>{{ $u->username }}</td>

                        <td>{{ $u->email }}</td>

                        <td>

                            @if($u->role == 'petugas')
                            <span class="badge bg-info">Petugas</span>
                            @else
                            <span class="badge bg-primary">Pemimpin</span>
                            @endif

                        </td>

                        <td>

                            @if($u->status == 'active')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif

                        </td>

                        <td>

                            <div class="d-flex gap-2">

                                <a href="/admin/users/edit/{{ $u->id }}" class="btn btn-sm btn-warning">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a href="/admin/users/toggle/{{ $u->id }}" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-ban"></i>
                                </a>

                                <button onclick="deleteUser('{{ $u->id }}')" class="btn btn-sm btn-danger">
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
function deleteUser(id) {

    Swal.fire({

        title: 'Hapus User?',
        text: 'User yang dihapus tidak bisa dikembalikan!',
        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',

        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'

    }).then((result) => {

        if (result.isConfirmed) {

            window.location.href = "/admin/users/delete/" + id

        }

    })

}
</script>

@endsection