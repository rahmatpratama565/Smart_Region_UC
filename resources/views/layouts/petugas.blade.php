<!DOCTYPE html>
<html>

<head>

    <title>Petugas - SmartRegion</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }


    /* NAVBAR FIXED */

    .navbar-custom {
        background: white;
        border-bottom: 1px solid #eee;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: 60px;
        z-index: 1100;
    }


    /* SIDEBAR */

    .sidebar {
        width: 240px;
        height: 100vh;
        background: white;
        border-right: 1px solid #eee;
        position: fixed;
        left: 0;
        top: 60px;
        /* OFFSET NAVBAR */
        z-index: 1000;
        transition: 0.3s;
    }


    /* MENU */

    .sidebar a {
        display: block;
        padding: 12px 20px;
        text-decoration: none;
        color: #333;
        font-weight: 500;
        border-left: 4px solid transparent;
        transition: all .2s;
    }


    /* HOVER */

    .sidebar a:hover {
        background: #f5f5f5;
        color: #000;
    }


    /* ACTIVE */

    .sidebar a.active-menu {
        background: #f1f3f5;
        border-left: 4px solid #000;
        color: #000;
        font-weight: 600;
    }


    /* ICON */

    .sidebar a i {
        width: 20px;
    }


    /* MAIN CONTENT */

    .main {
        margin-left: 240px;
        margin-top: 60px;
        /* OFFSET NAVBAR */
        transition: 0.3s;
    }


    /* MOBILE */

    @media(max-width:768px) {

        .sidebar {
            transform: translateX(-100%);
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .main {
            margin-left: 0;
        }

    }


    /* OVERLAY */

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
    </style>

</head>

<body>

    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>


    <!-- SIDEBAR -->

    <div class="sidebar" id="sidebar">

        <h4 class="text-center mt-3 mb-4">

            <i class="fa fa-chart-line"></i>
            SmartRegion

        </h4>


        <a href="/petugas" class="{{ request()->is('petugas') ? 'active-menu' : '' }}">

            <i class="fa fa-home me-2"></i>
            Dashboard

        </a>


        <a href="/petugas/data" class="{{ request()->is('petugas/data*') ? 'active-menu' : '' }}">

            <i class="fa fa-database me-2"></i>
            Input Data

        </a>


        <a href="#" onclick="logoutConfirm()">

            <i class="fa fa-sign-out-alt me-2"></i>
            Logout

        </a>

    </div>



    <!-- MAIN -->

    <div class="main">

        <nav class="navbar navbar-custom px-3">

            <button class="btn btn-light" onclick="toggleSidebar()">
                <i class="fa fa-bars"></i>
            </button>

            <span class="ms-auto fw-semibold">
                Petugas Panel
            </span>

        </nav>


        <div class="p-4">

            @yield('content')

        </div>

    </div>



    <script>
    function toggleSidebar() {

        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("overlay").classList.toggle("active");

    }


    function logoutConfirm() {

        Swal.fire({

            title: 'Yakin mau logout?',
            text: 'Anda akan keluar dari sistem',
            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#d33',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Ya Logout'

        }).then((result) => {

            if (result.isConfirmed) {

                window.location.href = "/logout"

            }

        })

    }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>