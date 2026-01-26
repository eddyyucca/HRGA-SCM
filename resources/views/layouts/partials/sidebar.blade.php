<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ url('/dashboard') }}" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image opacity-75 shadow">
            <span class="brand-text fw-light">GA System</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Header: Transport -->
                <li class="nav-header">TRANSPORT</li>

                <!-- Kendaraan -->
                <li class="nav-item {{ request()->is('transport/kendaraan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('transport/kendaraan*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-truck"></i>
                        <p>
                            Kendaraan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan') }}" class="nav-link {{ request()->is('transport/kendaraan') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Kendaraan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/peminjaman') }}" class="nav-link {{ request()->is('transport/kendaraan/peminjaman*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/maintenance') }}" class="nav-link {{ request()->is('transport/kendaraan/maintenance*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Maintenance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/bbm') }}" class="nav-link {{ request()->is('transport/kendaraan/bbm*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Log BBM</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Driver -->
                <li class="nav-item">
                    <a href="{{ url('/transport/driver') }}" class="nav-link {{ request()->is('transport/driver*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-badge"></i>
                        <p>Driver</p>
                    </a>
                </li>

                <!-- Header: Travel Management -->
                <li class="nav-header">TRAVEL MANAGEMENT</li>

                <!-- Ticketing -->
                <li class="nav-item {{ request()->is('travel/ticketing*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('travel/ticketing*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-ticket-perforated"></i>
                        <p>
                            Ticketing
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/request') }}" class="nav-link {{ request()->is('travel/ticketing/request*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Request Tiket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/booking') }}" class="nav-link {{ request()->is('travel/ticketing/booking*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/history') }}" class="nav-link {{ request()->is('travel/ticketing/history*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Visitor -->
                <li class="nav-item {{ request()->is('travel/visitor*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('travel/visitor*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-walking"></i>
                        <p>
                            Visitor
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/checkin') }}" class="nav-link {{ request()->is('travel/visitor/checkin*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Check In</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/register') }}" class="nav-link {{ request()->is('travel/visitor/register*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Registrasi Tamu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/log') }}" class="nav-link {{ request()->is('travel/visitor/log*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Log Kunjungan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Kontrak -->
                <li class="nav-header">KONTRAK</li>

                <li class="nav-item {{ request()->is('kontrak*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('kontrak*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-text"></i>
                        <p>
                            Manajemen Kontrak
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/kontrak') }}" class="nav-link {{ request()->is('kontrak') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Daftar Kontrak</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kontrak/vendor') }}" class="nav-link {{ request()->is('kontrak/vendor*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kontrak/reminder') }}" class="nav-link {{ request()->is('kontrak/reminder*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Reminder</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Inventory -->
                <li class="nav-header">INVENTORY</li>

                <li class="nav-item {{ request()->is('inventory*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('inventory*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-box-seam"></i>
                        <p>
                            Barang
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/inventory/barang') }}" class="nav-link {{ request()->is('inventory/barang') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/kategori') }}" class="nav-link {{ request()->is('inventory/kategori*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/masuk') }}" class="nav-link {{ request()->is('inventory/masuk*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/keluar') }}" class="nav-link {{ request()->is('inventory/keluar*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/opname') }}" class="nav-link {{ request()->is('inventory/opname*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Stock Opname</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Aset -->
                <li class="nav-item {{ request()->is('aset*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('aset*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-building"></i>
                        <p>
                            Aset
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/aset') }}" class="nav-link {{ request()->is('aset') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Data Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/aset/peminjaman') }}" class="nav-link {{ request()->is('aset/peminjaman*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Peminjaman Aset</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/aset/maintenance') }}" class="nav-link {{ request()->is('aset/maintenance*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Maintenance</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Reports & Settings -->
                <li class="nav-header">LAINNYA</li>

                <!-- Laporan -->
                <li class="nav-item {{ request()->is('laporan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-file-earmark-bar-graph"></i>
                        <p>
                            Laporan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/laporan/transport') }}" class="nav-link {{ request()->is('laporan/transport*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Transport</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan/inventory') }}" class="nav-link {{ request()->is('laporan/inventory*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan/kontrak') }}" class="nav-link {{ request()->is('laporan/kontrak*') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Laporan Kontrak</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ url('/settings') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>