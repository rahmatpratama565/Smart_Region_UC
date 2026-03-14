<!DOCTYPE html>
<html>

<head>

    <title>Login Admin - SmartRegion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body {
        background: #f5f7fb;
        font-family: 'Segoe UI', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
    }

    /* LOGIN CARD */

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 16px;
        background: white;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
    }

    /* LOGO */

    .login-logo {
        font-size: 48px;
        color: #0d6efd;
    }

    /* TITLE */

    .login-title {
        font-weight: 700;
        color: #0d6efd;
        margin-top: 10px;
    }

    .login-subtitle {
        font-size: 14px;
        color: #6c757d;
    }

    /* INPUT */

    .input-group-text {
        background: #f1f3f5;
        border: none;
    }

    .form-control {
        border-left: 0;
    }

    /* BUTTON */

    .btn-login {
        background: #0d6efd;
        border: none;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .btn-login:hover {
        background: #0b5ed7;
    }

    .login-footer {
        font-size: 13px;
        color: #6c757d;
    }
    </style>

</head>

<body>

    <div class="card login-card border-0">

        <div class="card-body p-4">

            @yield('content')

        </div>

    </div>


    <script>
    document.addEventListener("DOMContentLoaded", function() {

        @if(session('error'))

        Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '{{ session("error") }}'
        })

        @endif

        @if(session('success'))

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session("success") }}'
        })

        @endif

    });
    </script>

</body>

</html>