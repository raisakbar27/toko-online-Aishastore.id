<nav class="navbar navbar-expand-lg navbar-light navbar-store fixed-top navbar-fixed-top" data-aos="flip-down">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="/images/logo1.jpeg" width="80" alt="logo" />
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto navbar-display">
                <li class="nav-item">
                    <a href="/index.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="/categories.html" class="nav-link">Categories</a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">Rewards</a>
                </li>
            </ul>

            <!--Login Menu Navbar-->
            <ul class="navbar-nav d-none d-lg-flex">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link" id="navbarDropdown" data-toggle="dropdown">
                        <img src="/images/icon-user.png" alt="" class="rounded-circle mr-2 profile-picture" />
                        Hi, Angga
                    </a>
                    <div class="dropdown-menu">
                        <a href="/dashboard.html" class="dropdown-item">Dashboard</a>
                        <a href="/dashboard-account.html" class="dropdown-item">Pengaturan</a>
                        <div class="dropdown-divider"></div>
                        <a href="/" class="dropdown-item">Keluar</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link d-inline-block mt-2">
                        <img src="/images/cart-icon-empty.png" alt="" />
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav d-block d-lg-none">
                <li class="nav-item">
                    <a href="#" class="nav-link"> Hi,Angga </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link d-inline-block"> Keranjang </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
