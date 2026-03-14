@extends('layouts.auth-login-pemimpin')

@section('content')

<h5 class="text-center mb-4 fw-bold">
    Login Pemimpin
</h5>

@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<form method="POST" action="/pemimpin/login">

    @csrf

    <div class="mb-3">

        <label class="form-label">Username</label>

        <div class="input-group">

            <span class="input-group-text">
                <i class="fa fa-user"></i>
            </span>

            <input type="text" name="username" class="form-control" placeholder="Masukkan Username" required>

        </div>

    </div>


    <div class="mb-3">

        <label class="form-label">Password</label>

        <div class="input-group">

            <span class="input-group-text">
                <i class="fa fa-lock"></i>
            </span>

            <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>

        </div>

    </div>


    <button class="btn btn-login w-100 py-2">

        <i class="fa fa-sign-in-alt me-1"></i>
        Masuk

    </button>

</form>

@endsection