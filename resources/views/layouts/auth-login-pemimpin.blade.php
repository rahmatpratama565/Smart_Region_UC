<!DOCTYPE html>
<html>

<head>

    <title>Login Pemimpin - SmartRegion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    /* BODY */

    body {
        background: #f5f7fb;
        font-family: 'Segoe UI', sans-serif;
        height: 100vh;
    }

    /* LOGIN WRAPPER */

    .login-wrapper {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    /* LOGIN CARD */

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 14px;
        background: white;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* LOGO */

    .login-logo {
        font-size: 45px;
        color: #0d6efd;
    }

    /* TITLE */

    .login-title {
        font-weight: 700;
        color: #0d6efd;
    }

    .login-subtitle {
        font-size: 14px;
        color: #6c757d;
    }

    /* INPUT GROUP */

    .input-group-text {
        background: #f1f3f5;
    }

    /* BUTTON */

    .btn-login {
        background: #0d6efd;
        border: none;
        font-weight: 600;
    }

    .btn-login:hover {
        background: #0b5ed7;
    }

    /* FOOTER */

    .login-footer {
        font-size: 13px;
        color: #6c757d;
    }
    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="card border-0 login-card">

            <div class="card-body p-4">

                <!-- HEADER -->

                <div class="text-center mb-4">

                    <div class="login-logo">
                        <i class="fa fa-map-location-dot"></i>
                    </div>

                    <h4 class="login-title">
                        SmartRegion
                    </h4>

                    <div class="login-subtitle">
                        Sistem Monitoring Wilayah
                    </div>

                </div>

                @yield('content')

                <div class="text-center mt-4 login-footer">
                    © {{ date('Y') }} Pemerintah Daerah
                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(session('success'))

    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil logout',
        text: '{{ session('
        success ') }}',
        confirmButtonColor: '#0d6efd'
    })
    </script>

    @endif


    @if(session('error'))

    <script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '{{ session('
        error ') }}',
        confirmButtonColor: '#dc3545'
    })
    </script>

    @endif

</body>

</html>