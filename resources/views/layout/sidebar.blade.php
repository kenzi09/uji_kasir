<!DOCTYPE html>
<html dir="ltr" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Flexy Admin Lite</title>
    <link rel="stylesheet" href="//cdn.datatables.net/2.2.2/css/dataTables.dataTables.min.css">
    
    <!-- Bootstrap & Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Chart & Custom CSS -->
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('../dist/css/style.min.css') }}" rel="stylesheet">
    <style>
        /* Bikin sidebar full tinggi & warna dasar */
        .left-sidebar .sidebarnav {
            background-color: #b42323 !important;
            height: 100vh;
        }
        
        /* Scroll sidebar tetap di dalam sidebar */
        .scroll-sidebar {
            height: 100%;
            overflow-y: auto;
            padding-top: 20px;
        }
    
        /* Warna item sidebar default */
        .sidebar-nav .sidebar-item .sidebar-link {
            color:;
            background-color: transparent !important;
            border-radius: 12px;
            margin: 0 10px;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
    
        /* Warna item aktif (klik/terpilih) */
        .sidebar-nav .sidebar-item .sidebar-link.active,
        .sidebar-nav .sidebar-item .sidebar-link:hover {
            background-color: #650909 !important;
            color: #fff !important;
        }

    
        /* Logo area kasih padding supaya gak nempel */
        .navbar-header {
            padding: 20px;
            background-color: #b42323;
        }
    </style>
    
</head>

<body>
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>

    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        
        <!-- Header -->
        <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header" data-logobg="skin6">
                    <a class="navbar-brand" href="#">
                        <b class="logo-icon">
                            <img src="{{ asset('assets/images/pizza-hut.png') }}" alt="homepage" class="dark-logo" width="75" height="auto" />
                            {{-- <img src="{{ asset('assets/images/logo-light-icon.png') }}" alt="homepage" class="light-logo" /> --}}
                        </b>
                        <span class="logo-text">
                            {{-- <img src="{{ asset('assets/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                            <img src="{{ asset('assets/images/logo-light-text.png') }}" class="light-logo" alt="homepage" /> --}}
                        </span>
                    </a>
                    <a class="nav-toggler d-block d-md-none" href="javascript:void(0)">
                        <i class="mdi mdi-menu"></i>
                    </a>
                </div>

                <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                    <ul class="navbar-nav float-end">
        <li>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?')">
                @csrf
                <button type="submit" class="dropdown-item">
                    <i class="bi bi-box-arrow-right m-r-5 m-l-5"></i> Logout
                </button>
            </form>
        </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Sidebar -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    @php
                        $role = Auth::user()->role;
                        $prefix = $role === 'admin' ? 'admin' : 'petugas';
                    @endphp

                    <ul id="sidebarnav">
                        <!-- Dashboard -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" 
                                href="{{ route($prefix . '.dashboard') }}" aria-expanded="false">
                                <i class="mdi mdi-view-dashboard"></i>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                        </li>

                        <!-- Produk -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" 
                                href="{{ route($prefix . '.produks.index') }}" aria-expanded="false">
                                <i class="bi bi-shop"></i>
                                <span class="hide-menu">Produk</span>
                            </a>
                        </li>

                        <!-- Pembelian -->
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" 
                                href="{{ route($prefix . '.pembelian.index') }}" aria-expanded="false">
                                <i class="bi bi-cart3"></i>
                                <span class="hide-menu">Pembelian</span>
                            </a>
                        </li>

                        <!-- User (admin only) -->
                        @if($role === 'admin')
                            <li class="sidebar-item">
                                <a class="sidebar-link waves-effect waves-dark sidebar-link" 
                                    href="{{ route('admin.user.index') }}" aria-expanded="false">
                                    <i class="mdi mdi-account-network"></i>
                                    <span class="hide-menu">User</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <main class="ml-64 p-6">
            @yield('content')
        </main>

    </div>
    <script src="//cdn.datatables.net/2.2.2/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable');
    </script>

    <!-- JS Scripts -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../dist/js/app-style-switcher.js') }}"></script>
    <script src="{{ asset('../dist/js/waves.js') }}"></script>
    <script src="{{ asset('../dist/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('../dist/js/custom.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <script src="{{ asset('../dist/js/pages/dashboards/dashboard1.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>
</html>