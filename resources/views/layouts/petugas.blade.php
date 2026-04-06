<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Petugas - SmartRegion</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- SWEETALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* ================= GLOBAL ================= */
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .card {
        border-radius: 14px;
        border: none;
    }

    .btn {
        border-radius: 8px;
    }

    /* ================= NAVBAR ================= */
    .navbar-custom {
        background: white;
        border-bottom: 1px solid #eee;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        z-index: 1100;
        display: flex;
        align-items: center;
    }

    /* ================= SIDEBAR ================= */
    .sidebar {
        width: 240px;
        height: 100vh;
        background: white;
        border-right: 1px solid #eee;
        position: fixed;
        left: 0;
        top: 60px;
        z-index: 1000;
        transition: 0.3s;
        padding-top: 10px;
    }

    .sidebar h5 {
        font-weight: bold;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 20px;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        border-left: 4px solid transparent;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background: #f5f5f5;
    }

    .sidebar a.active-menu {
        background: #f1f3f5;
        border-left: 4px solid #000;
        font-weight: 600;
    }

    /* ================= MAIN ================= */
    .main {
        margin-left: 240px;
        margin-top: 60px;
        padding: 20px;
        transition: 0.3s;
    }

    /* ================= OVERLAY ================= */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.3);
        display: none;
        z-index: 999;
    }

    .overlay.active {
        display: block;
    }

    /* ================= MOBILE ================= */
    @media(max-width:768px) {

        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main {
            margin-left: 0;
            padding: 15px;
        }
    }
    </style>

</head>

<body>

    <!-- OVERLAY -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- ================= SIDEBAR ================= -->
    <div class="sidebar" id="sidebar">

        <h5 class="text-center mt-3 mb-4">
            <i class="fa fa-chart-line me-2"></i>
            SmartRegion
        </h5>

        <a href="/petugas" class="{{ request()->is('petugas') ? 'active-menu' : '' }}">
            <i class="fa fa-home"></i>
            Dashboard
        </a>

        <a href="/petugas/data" class="{{ request()->is('petugas/data*') ? 'active-menu' : '' }}">
            <i class="fa fa-database"></i>
            Data Wilayah
        </a>

        <a href="#" onclick="logoutConfirm()">
            <i class="fa fa-sign-out-alt"></i>
            Logout
        </a>

    </div>

    <!-- ================= MAIN ================= -->
    <div class="main">

        <!-- NAVBAR -->
        <nav class="navbar navbar-custom px-3">

            <button class="btn btn-light" onclick="toggleSidebar()">
                <i class="fa fa-bars"></i>
            </button>

            <span class="ms-auto fw-semibold">
                Petugas Panel
            </span>

        </nav>

        <!-- CONTENT -->
        <div class="mt-3">
            @yield('content')
        </div>

    </div>

    <!-- ================= SCRIPT ================= -->
    <script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("overlay").classList.toggle("active");
    }

    function logoutConfirm() {

        Swal.fire({
            title: 'Yakin logout?',
            text: 'Anda akan keluar dari sistem',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "/logout"
            }
        });

    }
    </script>

    <!-- BOOTSTRAP JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>