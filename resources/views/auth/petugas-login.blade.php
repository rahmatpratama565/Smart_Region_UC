@extends('layouts.auth-login-petugas')

@section('content')

@if(session('success'))
<script>
document.addEventListener("DOMContentLoaded", function() {

    Swal.fire({
        icon: 'success',
        title: 'Logout Berhasil',
        text: '{{ session("success") }}',
        confirmButtonColor: '#000'
    });

});
</script>
@endif


@if(session('error'))
<script>
document.addEventListener("DOMContentLoaded", function() {

    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session("error") }}',
        confirmButtonColor: '#000'
    });

});
</script>
@endif



<h5 class="text-center fw-bold mb-3">
    Login Petugas
</h5>

<p class="text-center text-muted mb-4">
    Silakan masuk ke sistem
</p>

<form method="POST" action="/petugas/login">

    @csrf

    <div class="mb-3 text-start">

        <label class="form-label fw-semibold">
            Username
        </label>

        <input type="text" class="form-control" name="username" placeholder="Masukkan username" required>

    </div>


    <div class="mb-3 text-start">

        <label class="form-label fw-semibold">
            Password
        </label>

        <input type="password" class="form-control" name="password" placeholder="Masukkan password" required>

    </div>


    <button class="btn btn-login w-100 mt-2">

        <i class="fa fa-sign-in-alt me-1"></i>
        Login

    </button>

</form>

@endsection