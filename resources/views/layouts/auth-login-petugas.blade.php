<!DOCTYPE html>
<html>

<head>

    <title>SmartRegion UC</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body {
        background: #f4f6f9;
        height: 100vh;
        font-family: 'Segoe UI', sans-serif;
    }

    .login-wrapper {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e5e5e5;
    }

    .logo {
        font-size: 30px;
        color: #111;
        margin-bottom: 10px;
    }

    .login-title {
        font-weight: 700;
        color: #111;
    }

    .login-subtitle {
        font-size: 13px;
        color: #6c757d;
    }

    .form-control {
        border: 1px solid #ddd;
    }

    .form-control:focus {
        border-color: #000;
        box-shadow: none;
    }

    .btn-login {
        background: #111;
        color: white;
        font-weight: 600;
    }

    .btn-login:hover {
        background: #333;
    }
    </style>

</head>

<body>

    <div class="login-wrapper">

        <div class="card shadow-sm login-card">

            <div class="card-body p-4 text-center">

                <i class="fa-solid fa-chart-line logo"></i>

                <h4 class="login-title">SmartRegion</h4>

                <p class="login-subtitle mb-4">
                    Sistem Monitoring Wilayah
                </p>

                @yield('content')

            </div>

        </div>

    </div>

</body>

</html>