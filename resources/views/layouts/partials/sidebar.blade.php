<aside class="app-sidebar shadow" style="background-color: #ffffff;">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 1.5rem 1rem;">
        <a href="{{ url('/dashboard') }}" class="brand-link" style="text-decoration: none;">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image" style="opacity: 1;">
            <span class="brand-text fw-bold" style="color: #ffffff; font-size: 1.2rem;">GA System</span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ url('/dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-speedometer2" style="color: #667eea;"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Header: Transport -->
                <li class="nav-header" style="color: #6c757d; font-weight: 600; font-size: 0.75rem; padding: 0.5rem 1rem; margin-top: 0.5rem;">TRANSPORT</li>

                <!-- Kendaraan -->
                <li class="nav-item {{ request()->is('transport/kendaraan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('transport/kendaraan*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-truck" style="color: #667eea;"></i>
                        <p>
                            Kendaraan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan') }}" class="nav-link {{ request()->is('transport/kendaraan') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Data Kendaraan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/peminjaman') }}" class="nav-link {{ request()->is('transport/kendaraan/peminjaman*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Peminjaman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/maintenance') }}" class="nav-link {{ request()->is('transport/kendaraan/maintenance*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Maintenance</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/transport/kendaraan/bbm') }}" class="nav-link {{ request()->is('transport/kendaraan/bbm*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Log BBM</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Driver -->
                <li class="nav-item">
                    <a href="{{ url('/transport/driver') }}" class="nav-link {{ request()->is('transport/driver*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-person-badge" style="color: #667eea;"></i>
                        <p>Driver</p>
                    </a>
                </li>

                <!-- Header: Travel Management -->
                <li class="nav-header" style="color: #6c757d; font-weight: 600; font-size: 0.75rem; padding: 0.5rem 1rem; margin-top: 0.5rem;">TRAVEL MANAGEMENT</li>

                <!-- Travel & Visitor -->
                <li class="nav-item">
                    <a href="{{ url('travel_visitor') }}" class="nav-link {{ request()->is('travel_visitor') && !request()->is('travel_visitor/report*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-calendar-check" style="color: #667eea;"></i>
                        <p>Travel & Visitor</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('travel_visitor/report') }}" class="nav-link {{ request()->is('travel_visitor/report*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-graph-up" style="color: #667eea;"></i>
                        <p>Report</p>
                    </a>
                </li>

                <!-- Ticketing -->
                <li class="nav-item {{ request()->is('travel/ticketing*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('travel/ticketing*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-ticket-perforated" style="color: #667eea;"></i>
                        <p>
                            Ticketing
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/request') }}" class="nav-link {{ request()->is('travel/ticketing/request*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Request Tiket</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/booking') }}" class="nav-link {{ request()->is('travel/ticketing/booking*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/ticketing/history') }}" class="nav-link {{ request()->is('travel/ticketing/history*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>History</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Visitor -->
                <li class="nav-item {{ request()->is('travel/visitor*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('travel/visitor*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-person-walking" style="color: #667eea;"></i>
                        <p>
                            Visitor
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/checkin') }}" class="nav-link {{ request()->is('travel/visitor/checkin*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Check In</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/register') }}" class="nav-link {{ request()->is('travel/visitor/register*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Registrasi Tamu</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/travel/visitor/log') }}" class="nav-link {{ request()->is('travel/visitor/log*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Log Kunjungan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Kontrak -->
                <li class="nav-header" style="color: #6c757d; font-weight: 600; font-size: 0.75rem; padding: 0.5rem 1rem; margin-top: 0.5rem;">KONTRAK</li>

                <li class="nav-item {{ request()->is('kontrak*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('kontrak*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-file-earmark-text" style="color: #667eea;"></i>
                        <p>
                            Manajemen Kontrak
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/kontrak') }}" class="nav-link {{ request()->is('kontrak') && !request()->is('kontrak/*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Daftar Kontrak</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kontrak/vendor') }}" class="nav-link {{ request()->is('kontrak/vendor*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Data Vendor</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/kontrak/reminder') }}" class="nav-link {{ request()->is('kontrak/reminder*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Reminder</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Asset -->
          
    <li class="nav-header">SPACE OPS</li>

<li class="nav-item">
  <a href="{{ route('spaceops.dashboard') }}" class="nav-link">
    <i class="nav-icon fas fa-tachometer-alt"></i>
    <p>SpaceOps Dashboard</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('spaceops.spaces') }}" class="nav-link">
    <i class="nav-icon fas fa-building"></i>
    <p>Master Spaces</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('spaceops.rooming') }}" class="nav-link">
    <i class="nav-icon fas fa-bed"></i>
    <p>Rooming</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('spaceops.rooming.vacant') }}" class="nav-link">
    <i class="nav-icon fas fa-door-open"></i>
    <p>Vacant Beds</p>
  </a>
</li>

<li class="nav-item">
  <a href="{{ route('spaceops.assets') }}" class="nav-link">
    <i class="nav-icon fas fa-boxes"></i>
    <p>Space Assets</p>
  </a>
</li>

                <!-- Barang (Existing) -->
                <li class="nav-item {{ request()->is('inventory/barang*') || request()->is('inventory/kategori*') || request()->is('inventory/masuk*') || request()->is('inventory/keluar*') || request()->is('inventory/opname*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('inventory/barang*') || request()->is('inventory/kategori*') || request()->is('inventory/masuk*') || request()->is('inventory/keluar*') || request()->is('inventory/opname*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-box-seam" style="color: #667eea;"></i>
                        <p>
                            Barang
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/inventory/barang') }}" class="nav-link {{ request()->is('inventory/barang') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Data Barang</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/kategori') }}" class="nav-link {{ request()->is('inventory/kategori*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Kategori</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/masuk') }}" class="nav-link {{ request()->is('inventory/masuk*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Barang Masuk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/keluar') }}" class="nav-link {{ request()->is('inventory/keluar*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Barang Keluar</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/inventory/opname') }}" class="nav-link {{ request()->is('inventory/opname*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Stock Opname</p>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Header: Task Force -->
                <li class="nav-header" style="color: #6c757d; font-weight: 600; font-size: 0.75rem; padding: 0.5rem 1rem; margin-top: 0.5rem;">TASK FORCE</li>

                <li class="nav-item {{ request()->is('taskforce*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('taskforce*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-list-check" style="color: #667eea;"></i>
                        <p>
                            Tasks
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/taskforce/team') }}" class="nav-link {{ request()->is('taskforce/team*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Team</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/taskforce/report') }}" class="nav-link {{ request()->is('taskforce/report*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Report</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Header: Reports & Settings -->
                <li class="nav-header" style="color: #6c757d; font-weight: 600; font-size: 0.75rem; padding: 0.5rem 1rem; margin-top: 0.5rem;">LAINNYA</li>

                <!-- Laporan -->
                <li class="nav-item {{ request()->is('laporan*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-file-earmark-bar-graph" style="color: #667eea;"></i>
                        <p>
                            Laporan
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ url('/laporan/transport') }}" class="nav-link {{ request()->is('laporan/transport*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Laporan Transport</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan/inventory') }}" class="nav-link {{ request()->is('laporan/inventory*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Laporan Inventory</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/laporan/kontrak') }}" class="nav-link {{ request()->is('laporan/kontrak*') ? 'active' : '' }}" style="color: #6c757d;">
                                <i class="nav-icon bi bi-circle" style="font-size: 0.5rem;"></i>
                                <p>Laporan Kontrak</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Settings -->
                <li class="nav-item">
                    <a href="{{ url('/settings') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}" style="color: #495057;">
                        <i class="nav-icon bi bi-gear" style="color: #667eea;"></i>
                        <p>Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
