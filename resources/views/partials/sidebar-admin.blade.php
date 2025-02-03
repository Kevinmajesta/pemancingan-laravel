<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="/">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        <!-- Schedule -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#scheduleMenu" aria-controls="scheduleMenu">
                <i class="mdi mdi-calendar menu-icon"></i>
                <span class="menu-title">Schedule</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="scheduleMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <span class="nav-link" style="cursor: pointer;" onclick="window.location='/schedule/admin'">
                            Schedule
                        </span>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Kritik dan Saran -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#kritikMenu" aria-controls="kritikMenu">
                <i class="mdi mdi-comment-text menu-icon"></i>
                <span class="menu-title">Kritik</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="kritikMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <span class="nav-link" style="cursor: pointer;" onclick="window.location='/kritik/admin'">
                            Kritik dan Saran
                        </span>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Pemenang -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#pemenangMenu" aria-controls="pemenangMenu">
                <i class="mdi mdi-crown menu-icon"></i>
                <span class="menu-title">Pemenang</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="pemenangMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <span class="nav-link" style="cursor: pointer;" onclick="window.location='/game/best-customer'">
                            Skor Pelanggan Terbaik
                        </span>
                    </li>
                    <li class="nav-item">
                        <span class="nav-link" style="cursor: pointer;" onclick="window.location='/game/winners'">
                            List Pelanggan Terbaik
                        </span>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Game -->
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#gameMenu" aria-controls="gameMenu">
                <i class="mdi mdi-gamepad-variant menu-icon"></i>
                <span class="menu-title">Game</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="gameMenu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <span class="nav-link" style="cursor: pointer;" onclick="window.location='{{ route('games.indexUser') }}'">
                            Game
                        </span>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</nav>
