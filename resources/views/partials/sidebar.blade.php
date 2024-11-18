<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="icon-layout menu-icon"></i>
                <span class="menu-title">UI Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/buttons">Buttons</a></li>
                    <li class="nav-item"><a class="nav-link" href="/dropdowns">Dropdowns</a></li>
                    <li class="nav-item"><a class="nav-link" href="/typography">Typography</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Form Elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/forms">Basic Elements</a></li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#schedule" aria-expanded="false" aria-controls="schedule">
                <i class="mdi mdi-table-large menu-icon"></i>
                <span class="menu-title">Schedule</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="schedule">
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

        {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#charts" aria-expanded="false" aria-controls="charts">
                <i class="icon-bar-graph menu-icon"></i>
                <span class="menu-title">Charts</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="charts">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/chart">ChartJs</a></li>
                </ul>
            </div>
        </li> --}}

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kritik" aria-expanded="false" aria-controls="kritik">
                <i class="mdi mdi-comment-processing-outline menu-icon"></i>
                <span class="menu-title">Kritik dan Saran</span>
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
            <a class="nav-link" data-toggle="collapse" href="#pemenang" aria-expanded="false" aria-controls="pemenang">
                <i class="mdi mdi-crown menu-icon"></i>
                <span class="menu-title">Pemenang</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pemenang">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/champs' : '/champs/user' }}">
                            Pemenang
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? '/game/best-customer' : '/game/best-customer' }}">
                            Pemenang AHP
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                <i class="icon-grid-2 menu-icon"></i>
                <span class="menu-title">Tables</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="tables">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/table">Basic Table</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#game" aria-expanded="false" aria-controls="game">
                <i class="icon-contract menu-icon"></i>
                <span class="menu-title">Game</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="game">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link"
                            href="{{ Auth::check() && Auth::user()->role === 'admin' ? route('games.create') : route('games.indexUser') }}">
                            Game
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#icons" aria-expanded="false" aria-controls="icons">
                <i class="icon-contract menu-icon"></i>
                <span class="menu-title">Icons</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="icons">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/icons">Mdi Icons</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
                <i class="icon-head menu-icon"></i>
                <span class="menu-title">User Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="auth">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/login">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="/register">Register</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#error" aria-expanded="false" aria-controls="error">
                <i class="icon-ban menu-icon"></i>
                <span class="menu-title">Error Pages</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="error">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="/erro404">404</a></li>
                    <li class="nav-item"><a class="nav-link" href="/erro500">500</a></li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="https://github.com/M-Hidayatullah" target="_blank">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Author</span>
            </a>
        </li>
    </ul>
</nav>
