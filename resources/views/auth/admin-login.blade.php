@extends('layouts.auth-login-admin')

@section('content')

<style>
/* WRAPPER */

.login-wrapper {
    max-width: 420px;
    margin: auto;
    padding: 10px;
}


/* LOGO */

.login-logo {
    font-size: 42px;
    color: #0d6efd;
    background: #f1f5ff;
    width: 70px;
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    margin: auto;
}


/* TITLE */

.login-title {
    font-weight: 600;
    margin-bottom: 3px;
}


/* SUBTITLE */

.login-subtitle {
    font-size: 13px;
    color: #6c757d;
}


/* BUTTON */

.btn-login {
    background: #0d6efd;
    color: white;
    border: none;
    transition: 0.2s;
}

.btn-login:hover {
    background: #0b5ed7;
}


/* MOBILE */

@media(max-width:576px) {

    .login-wrapper {
        padding: 5px;
    }

    .login-logo {
        width: 60px;
        height: 60px;
        font-size: 34px;
    }

    .login-title {
        font-size: 20px;
    }

    .login-subtitle {
        font-size: 12px;
    }

    .form-control {
        font-size: 14px;
    }

    .btn-login {
        font-size: 14px;
    }

}
</style>



<div class="login-wrapper">

    <form method="POST" action="/admin/login">

        @csrf


        <!-- HEADER -->

        <div class="text-center mb-4">

            <div class="login-logo mb-2">
                <i class="fa fa-user-shield"></i>
            </div>

            <h4 class="login-title">
                Login Administrator
            </h4>

            <div class="login-subtitle">
                Silakan masuk untuk mengakses sistem SmartRegion
            </div>

        </div>



        <!-- USERNAME -->

        <div class="mb-3">

            <label class="form-label fw-semibold">
                Username
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="fa fa-user"></i>
                </span>

                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>

            </div>

        </div>



        <!-- PASSWORD -->

        <div class="mb-4">

            <label class="form-label fw-semibold">
                Password
            </label>

            <div class="input-group">

                <span class="input-group-text">
                    <i class="fa fa-lock"></i>
                </span>

                <input type="password" name="password" id="password" class="form-control"
                    placeholder="Masukkan password" required>

                <button type="button" class="btn btn-outline-secondary" onclick="togglePassword()">

                    <i id="eyeIcon" class="fa fa-eye"></i>

                </button>

            </div>

        </div>



        <!-- LOGIN BUTTON -->

        <button class="btn btn-login w-100 py-2">

            <i class="fa fa-right-to-bracket me-1"></i>
            Login

        </button>

    </form>



    <!-- FOOTER -->

    <div class="text-center mt-4">

        <small class="text-muted">

            Sistem Monitoring Wilayah <br>
            © {{ date('Y') }} SmartRegion

        </small>

    </div>

</div>



<script>
function togglePassword() {

    let password = document.getElementById("password");
    let icon = document.getElementById("eyeIcon");

    if (password.type === "password") {

        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");

    } else {

        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");

    }

}
</script>

@endsection