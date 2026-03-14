<!DOCTYPE html>
<html>

<head>

    <title>Admin Panel - SmartRegion UC</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <style>
    /* GLOBAL */

    body {
        background: #f1f5f9;
        font-family: 'Segoe UI', sans-serif;
    }


    /* NAVBAR */

    .navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
    }


    /* NAVBAR BRAND */

    .navbar-brand {
        font-weight: 600;
        font-size: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }


    /* USER */

    .user-box {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        max-width: 160px;
    }

    .user-box span {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-size: 14px;
    }


    /* AVATAR */

    .user-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #2563eb;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 14px;
        flex-shrink: 0;
    }


    /* SIDEBAR */

    .sidebar {
        position: fixed;
        top: 60px;
        left: 0;
        bottom: 0;
        width: 240px;
        background: linear-gradient(180deg, #1e3a8a, #2563eb);
        padding-top: 20px;
        transition: 0.3s;
        z-index: 1001;
        overflow-y: auto;
    }

    .sidebar-title {
        color: white;
        font-weight: bold;
        font-size: 18px;
        text-align: center;
        margin-bottom: 25px;
    }

    .sidebar a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #e5e7eb;
        padding: 12px 20px;
        text-decoration: none;
        font-size: 14px;
        transition: .3s;
        border-left: 4px solid transparent;
    }

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .sidebar a.active-menu {
        background: rgba(255, 255, 255, 0.20);
        border-left: 4px solid #ffffff;
        color: white;
        font-weight: 600;
    }

    .sidebar a i {
        width: 18px;
    }


    /* CONTENT */

    .content {
        margin-left: 240px;
        margin-top: 70px;
        padding: 25px;
        transition: 0.3s;
    }


    /* CARD */

    .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }


    /* OVERLAY */

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.35);
        display: none;
        z-index: 1000;
    }

    .overlay.active {
        display: block;
    }


    /* ===================================
RESPONSIVE MOBILE
=================================== */

    @media(max-width:768px) {

        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .content {
            margin-left: 0;
            padding: 18px;
        }

        .navbar-brand span {
            display: none;
        }

        .user-box span {
            display: none;
        }

        /* spacing dashboard */

        .row {
            row-gap: 16px;
        }

        .card {
            border-radius: 14px;
        }

        .card h4 {
            font-size: 22px;
        }

        .card h6 {
            font-size: 13px;
        }

    }


    /* EXTRA SMALL PHONE */

    @media(max-width:480px) {

        .content {
            padding: 14px;
        }

        .navbar {
            padding-left: 10px;
            padding-right: 10px;
        }

    }
    </style>

</head>

<body>


    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>


    <!-- NAVBAR -->

    <nav class="navbar px-3">

        <button class="btn btn-light me-3" onclick="toggleSidebar()">
            <i class="fa fa-bars"></i>
        </button>

        <div class="navbar-brand text-primary">
            <i class="fa fa-map"></i>
            <span>SmartRegion Dashboard</span>
        </div>

        <div class="ms-auto user-box">

            <div class="user-avatar">
                {{ strtoupper(substr(Auth::user()->name,0,1)) }}
            </div>

            <span>
                {{ Auth::user()->name }}
            </span>

        </div>

    </nav>



    <!-- SIDEBAR -->

    <div class="sidebar" id="sidebar">

        <div class="sidebar-title">
            SmartRegion
        </div>

        <a href="/admin" class="{{ request()->is('admin') ? 'active-menu' : '' }}">
            <i class="fa fa-chart-line"></i>
            Dashboard
        </a>

        <a href="/admin/wilayah" class="{{ request()->is('admin/wilayah*') ? 'active-menu' : '' }}">
            <i class="fa fa-map-location-dot"></i>
            Monitoring Wilayah
        </a>

        <a href="/admin/users" class="{{ request()->is('admin/users*') ? 'active-menu' : '' }}">
            <i class="fa fa-users"></i>
            Manajemen Akun
        </a>

        <a href="/admin/laporan" class="{{ request()->is('admin/laporan*') ? 'active-menu' : '' }}">
            <i class="fa fa-file-lines"></i>
            Rekap Laporan
        </a>

        <a href="/admin/security" class="{{ request()->is('admin/security*') ? 'active-menu' : '' }}">
            <i class="fa fa-shield-halved"></i>
            Security Logs
        </a>

        <a href="#" onclick="confirmLogout()">
            <i class="fa fa-right-from-bracket"></i>
            Logout
        </a>

    </div>



    <!-- CONTENT -->

    <div class="content">

        @yield('content')

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>



    <script>
    function toggleSidebar() {

        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("overlay").classList.toggle("active");

    }
    </script>



    <script>
    @if(session('success'))

    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session("success") }}'
    })

    @endif


    @if(session('error'))

    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session("error") }}'
    })

    @endif
    </script>



    <script>
    function confirmLogout() {

        Swal.fire({

            title: 'Logout ?',
            text: 'Apakah anda yakin ingin keluar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location = "/logout";

            }

        })

    }
    </script>

</body>

</html>