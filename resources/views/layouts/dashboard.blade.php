<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>@yield('title')</title>

    @stack('prepend-style')
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <link href="/style/main.css" rel="stylesheet" />
    <link rel="icon" href="path/to/your/favicon.ico" type="image/x-icon" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('addon-style')
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <img src="/images/logo-aisha.jpeg" alt="" class="my-4" style="max-width: 150px" />
                </div>
                <div class="list-group list-group-flush">
                    @if (Auth::user()->roles === 'CS')
                        <a href="{{ route('dashboard') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">
                            Dashboard
                        </a>

                        <a href="{{ route('dashboard-product') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard/product') ? 'active' : '' }}">
                            Produk
                        </a>

                        <a href="{{ route('dashboard-transaction') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard/transaction*') ? 'active' : '' }}">
                            Transaksi
                        </a>
                    @endif
                    @if (Auth::user()->roles === 'USER')
                        <a href="{{ route('dashboard-history') }}"
                            class="list-group-item list-group-item-action {{ request()->is('dashboard/history*') ? 'active' : '' }}">
                            Riwayat Pembelian
                        </a>
                    @endif
                    <a href="{{ route('dashboard-setting') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/setting*') ? 'active' : '' }}">
                        Pengaturan
                    </a>
                    <a href="{{ route('dashboard-account') }}"
                        class="list-group-item list-group-item-action {{ request()->is('dashboard/account*') ? 'active' : '' }}">
                        Profile
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                        class="list-group-item list-group-item-action">
                        Keluar
                    </a>
                </div>
            </div>


            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top" data-aos="flip-down">
                    <div class="container-fluid">
                        <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                            &laquo; Menu
                        </button>

                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <!--Login Menu Navbar-->
                            <ul class="navbar-nav d-none d-lg-flex ml-auto">
                                <li class="nav-item dropdown">
                                    <a href="#" class="nav-link" id="navbarDropdown" data-toggle="dropdown">
                                        <img src="/images/user.png" alt=""
                                            class="rounded-circle mr-2 profile-picture" />
                                        Hi, {{ Auth::user()->name }}
                                    </a>
                                    <div class="dropdown-menu">
                                        <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                                        <a href="{{ route('dashboard-account') }}" class="dropdown-item">Pengaturan</a>
                                        <div class="dropdown-divider"></div>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();""
                                            class="dropdown-item">Keluar</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cart') }}" class="nav-link d-inline-block mt-2">

                                        @php
                                            $carts = \App\Cart::where('users_id', Auth::user()->id)->count();
                                        @endphp
                                        @if ($carts > 0)
                                            <img src="/images/cart-icon-empty.png" alt="" />
                                            <div class="card-badge">{{ $carts }}</div>
                                        @else
                                            <img src="/images/cart-icon-empty.png" alt="" />
                                        @endif
                                    </a>
                                </li>
                            </ul>
                            <ul class="navbar-nav d-block d-lg-none">
                                <li class="nav-item">
                                    <a href="#" class="nav-link"> Hi, </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link d-inline-block"> Keranjang </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                {{-- Content --}}
                @yield('content')


            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    @stack('prepend-script')
    <script src="/vendor/jquery/jquery.slim.min.js"></script>
    <script src="/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
    @stack('addon-script')
</body>

</html>
