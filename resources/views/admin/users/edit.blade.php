@extends('layouts.admin')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">

        <h5 class="mb-0 text-primary">

            <i class="fa fa-user-edit"></i>
            Edit Akun

        </h5>

    </div>


    <div class="card-body">

        <form method="POST" action="/admin/users/update/{{ $user->id }}">

            @csrf


            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">Nama</label>

                    <input type="text" name="name" value="{{ $user->name }}" class="form-control">

                </div>


                <div class="col-md-6">

                    <label class="form-label">Username</label>

                    <input type="text" name="username" value="{{ $user->username }}" class="form-control">

                </div>


                <div class="col-md-6">

                    <label class="form-label">Email</label>

                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">

                </div>


                <div class="col-md-6">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select">

                        <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>

                            Petugas

                        </option>

                        <option value="pemimpin" {{ $user->role == 'pemimpin' ? 'selected' : '' }}>

                            Pemimpin

                        </option>

                    </select>

                </div>

            </div>


            <div class="mt-4">

                <button class="btn btn-primary">

                    <i class="fa fa-save"></i>
                    Update

                </button>


                <a href="/admin/users" class="btn btn-secondary">

                    <i class="fa fa-arrow-left"></i>
                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection