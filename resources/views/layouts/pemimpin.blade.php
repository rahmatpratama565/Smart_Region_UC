<!DOCTYPE html>
<html>

<head>

    <title>Pemimpin - SmartRegion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    /* GLOBAL */

    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
        overflow-x: hidden;
    }


    /* NAVBAR */

    .navbar {
        position: fixed;
        top: 0;
        left: 240px;
        right: 0;
        height: 60px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
        z-index: 1100;
        display: flex;
        align-items: center;
        transition: 0.3s;
    }


    /* SIDEBAR */

    .sidebar {
        width: 240px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;

        /* GRADIENT BIRU MUDA ELEGAN */

        background: linear-gradient(180deg,
                #1e40af,
                #3b82f6);

        color: white;
        transition: 0.3s;
        z-index: 1200;
    }


    /* SIDEBAR BRAND */

    .sidebar-brand {
        font-size: 20px;
        font-weight: bold;
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }


    /* SIDEBAR MENU */

    .sidebar a {
        display: block;
        padding: 12px 20px;
        color: #e5e7eb;
        text-decoration: none;
        font-size: 15px;
        transition: 0.2s;
        border-left: 4px solid transparent;
    }


    /* HOVER */

    .sidebar a:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        padding-left: 25px;
    }


    /* ACTIVE MENU */

    .sidebar a.active-menu {
        background: rgba(255, 255, 255, 0.20);
        border-left: 4px solid #ffffff;
        color: white;
        font-weight: 600;
    }


    /* CONTENT */

    .content {
        margin-left: 240px;
        padding-top: 70px;
        transition: 0.3s;
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
        z-index: 1100;
    }

    .overlay.active {
        display: block;
    }


    /* RESPONSIVE */

    @media(max-width:900px) {

        .sidebar {
            left: -240px;
        }

        .sidebar.active {
            left: 0;
        }

        .content {
            margin-left: 0;
        }

        .navbar {
            left: 0;
        }

    }
    </style>

</head>

<body>


    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>


    <!-- SIDEBAR -->

    <div class="sidebar" id="sidebar">

        <div class="sidebar-brand">

            <i class="fa fa-map-location-dot"></i>
            SmartRegion

        </div>


        <a href="/pemimpin" class="{{ request()->is('pemimpin') ? 'active-menu' : '' }}">

            <i class="fa fa-chart-line me-2"></i>
            Dashboard

        </a>


        <a href="/pemimpin/wilayah" class="{{ request()->is('pemimpin/wilayah*') ? 'active-menu' : '' }}">

            <i class="fa fa-map me-2"></i>
            Monitoring Wilayah

        </a>


        <a href="/pemimpin/laporan" class="{{ request()->is('pemimpin/laporan*') ? 'active-menu' : '' }}">

            <i class="fa fa-file-lines me-2"></i>
            Laporan

        </a>


        <a href="#" onclick="confirmLogout()">

            <i class="fa fa-sign-out-alt me-2"></i>
            Logout

        </a>

    </div>


    <!-- NAVBAR -->

    <nav class="navbar px-3">

        <button class="btn btn-light me-3" onclick="toggleSidebar()">

            <i class="fa fa-bars"></i>

        </button>

        <div class="fw-semibold">
            Dashboard Pemimpin
        </div>

        <div class="ms-auto">

            <i class="fa fa-user-circle me-2"></i>
            Pemimpin

        </div>

    </nav>


    <!-- CONTENT -->

    <div class="content">

        <div class="container-fluid">

            @yield('content')

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    /* SIDEBAR TOGGLE */

    function toggleSidebar() {

        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");

        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");

    }


    /* LOGOUT CONFIRM */

    function confirmLogout() {

        Swal.fire({

            title: 'Logout ?',

            text: 'Apakah anda yakin ingin logout',

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#dc3545',

            cancelButtonColor: '#6c757d',

            confirmButtonText: 'Logout',

            cancelButtonText: 'Batal'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = "/logout";

            }

        })

    }


    /* LOGIN SUCCESS POPUP */

    @if(session('success'))

    Swal.fire({

        icon: 'success',

        title: 'Login berhasil',

        text: '{{ session("success") }}',

        confirmButtonColor: '#0d6efd'

    });

    @endif
    </script>

    @yield('scripts')

</body>

</html>