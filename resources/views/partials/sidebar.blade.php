<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Schedule</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/schedule/admin' : '/schedule/user' }}">
                            Schedule
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kritik" aria-expanded="false" aria-controls="kritik">
                <i class="mdi mdi-comment-text menu-icon"></i>
                <span class="menu-title">Kritik</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="kritik">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/kritik/admin' : '/kritik/user' }}">
                            Kritik dan Saran
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="mdi mdi-crown menu-icon"></i>
                <span class="menu-title">Pemenang</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/game/best-customer' : '/game/best-customer' }}">
                            Pelanggan Terbaik 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/champs' : '/champs/user' }}">
                            Pemenang 
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#game" aria-expanded="false" aria-controls="game">
                <i class="mdi mdi-gamepad-variant menu-icon"></i>
                <span class="menu-title">Game</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="game">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('games.indexUser') : route('games.indexUser') }}">
                            Game
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
