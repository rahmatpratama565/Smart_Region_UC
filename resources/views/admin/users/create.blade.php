@extends('layouts.admin')

@section('content')

<div class="card shadow-sm">

    <div class="card-header">

        <h5 class="mb-0 text-primary">

            <i class="fa fa-user-plus"></i>
            Tambah Akun

        </h5>

    </div>


    <div class="card-body">

        <form method="POST" action="/admin/users/store">

            @csrf


            <div class="row g-3">

                <div class="col-md-6">

                    <label class="form-label">Nama</label>

                    <input type="text" name="name" class="form-control" required>

                </div>


                <div class="col-md-6">

                    <label class="form-label">Username</label>

                    <input type="text" name="username" class="form-control" required>

                </div>


                <div class="col-md-6">

                    <label class="form-label">Email</label>

                    <input type="email" name="email" class="form-control" required>

                </div>


                <div class="col-md-6">

                    <label class="form-label">Password</label>

                    <input type="password" name="password" class="form-control" required>

                </div>


                <div class="col-md-6">

                    <label class="form-label">Role</label>

                    <select name="role" class="form-select">

                        <option value="petugas">Petugas</option>

                        <option value="pemimpin">Pemimpin</option>

                    </select>

                </div>

            </div>


            <div class="mt-4">

                <button class="btn btn-success">

                    <i class="fa fa-save"></i>
                    Simpan

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