<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start"
        style="background-color: #f8f9fa; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
        <a class="navbar-brand brand-logo d-flex align-items-center text-decoration-none" href="">
            <img src="{{ asset('assets/images/dashboard/_9DEF9ABB-4ED2-4277-B842-E808062D0538_-removebg-preview.png') }}"
                class="mr-3" alt="logo" style="width: 50px; height: auto; border-radius: 50%;" />
            <span class="brand-text font-weight-bold"
                style="font-size: 1.5rem; color: #4B49AC; font-family: 'Poppins', sans-serif;">R&Y Fishing</span>
        </a>
    </div>



    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <ul class="navbar-nav navbar-nav-right">
            <li class="nav-item nav-profile dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                    <!-- Menampilkan nama pengguna jika login -->
                    @auth
                        <span>{{ Auth::user()->name }}</span>
                    @else
                        <span>Login</span>
                    @endauth
                </a>

                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                    @auth
                        <!-- Jika pengguna sudah login, tampilkan Settings dan Logout -->
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="ti-settings text-primary"></i>
                            Settings Profile
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="ti-power-off text-primary"></i>
                            Logout
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <!-- Jika pengguna belum login, tampilkan Login -->
                        <a class="dropdown-item" href="{{ route('login') }}">
                            <i class="ti-power-off text-primary"></i>
                            Login
                        </a>
                    @endauth
                </div>
            </li>

    </div>
</nav>
