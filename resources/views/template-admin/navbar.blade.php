<div class="nav-container primary-menu">
    <div class="mobile-topbar-header">
        <div>
            <img src="{{ asset('admin') }}/assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">RAPP</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
        </div>
    </div>
    <nav class="navbar navbar-expand-xl w-100">
        <ul class="navbar-nav justify-content-start flex-grow-1 gap-1">
            <li class="nav-item dropdown">
                <a href="/dashboard"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('dashboard') ? 'active' : '' }}">
                    <div class="parent-icon"><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title">Dashboard</div>
                </a>
            </li>
            @if (auth()->user()->role == 'admin')
                <li class="nav-item dropdown">
                    <a href="/manajemen-akun"
                        class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('manajemen-akun') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">Manajemen Akun</div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="/supplier"
                        class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('supplier') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-user'></i>
                        </div>
                        <div class="menu-title">Supplier</div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="/barang"
                        class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('barang') ? 'active' : '' }}">
                        <div class="parent-icon"><i class='bx bx-box'></i>
                        </div>
                        <div class="menu-title">Barang</div>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret"
                        data-bs-toggle="dropdown">
                        <div class="parent-icon"><i class='bx bx-printer text-success'></i></div>
                        <div class="menu-title">Laporan</div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan') ? 'active' : '' }} text-success" target="_blank"
                                href="/laporan/barang-masuk">
                                <i class="bx bx-upload"></i>Laporan Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan/barang-keluar') ? 'active' : '' }} text-success" target="_blank"
                                href="/laporan/barang-keluar">
                                <i class="bx bx-download"></i>Laporan Barang Keluar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan/barang-rusak') ? 'active' : '' }} text-success" target="_blank" href="/laporan/barang-rusak">
                                <i class="bx bx-download"></i>Laporan Barang Rusak
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

           

            @if (auth()->user()->role == 'asisten_kiper')
                
            <li class="nav-item dropdown">
                <a href="/barang-masuk"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('barang-masuk') ? 'active' : '' }}">
                    <div class="parent-icon"><i class='bx bx-box'></i>
                    </div>
                    <div class="menu-title">Barang Masuk</div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="/barang-keluar"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('barang-keluar') ? 'active' : '' }}">
                    <div class="parent-icon"><i class='bx bx-box'></i>
                    </div>
                    <div class="menu-title">Barang Keluar</div>
                </a>
            </li>
            <li class="nav-item dropdown">
                <a href="/barang-rusak"
                    class="nav-link dropdown-toggle dropdown-toggle-nocaret {{ Request::is('barang-rusak') ? 'active' : '' }}">
                    <div class="parent-icon"><i class='bx bx-error-circle'></i>
                    </div>
                    <div class="menu-title">Barang Rusak</div>
                </a>
            </li>
                <li class="nav-item dropdown">
                    <a href="javascript:;" class="nav-link dropdown-toggle dropdown-toggle-nocaret" data-bs-toggle="dropdown">
                        <div class="parent-icon"><i class='bx bx-printer text-success'></i></div>
                        <div class="menu-title">Laporan</div>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan') ? 'active' : '' }} text-success" target="_blank" href="/laporan/barang-masuk">
                                <i class="bx bx-upload"></i>Laporan Barang Masuk
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan/barang-keluar') ? 'active' : '' }} text-success" target="_blank" href="/laporan/barang-keluar">
                                <i class="bx bx-download"></i>Laporan Barang Keluar
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item {{ Request::is('laporan/barang-rusak') ? 'active' : '' }} text-success" target="_blank" href="/laporan/barang-rusak">
                                <i class="bx bx-download"></i>Laporan Barang Rusak
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
</div>
