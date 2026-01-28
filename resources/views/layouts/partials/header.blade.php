<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- Logo Kiri -->
        <div class="navbar-brand-wrapper d-flex align-items-center me-3">
            <img src="{{ asset('images/SCM.jpeg') }}" alt="Logo Left" class="brand-image" style="height: 40px; width: auto; max-height: 50px;">
        </div>

        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ url('/') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ms-auto">
            <!-- Notifications -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-bs-toggle="dropdown" href="#">
                    <i class="bi bi-bell-fill"></i>
                    <span class="navbar-badge badge text-bg-warning">3</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <span class="dropdown-item dropdown-header">3 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="bi bi-envelope me-2"></i> New message
                        <span class="float-end text-secondary fs-7">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All</a>
                </div>
            </li>

            <!-- Fullscreen -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i class="bi bi-arrows-fullscreen"></i>
                </a>
            </li>

            <!-- User Menu -->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="https://ui-avatars.com/api/?name=User&background=random" 
                         class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">User</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <li class="user-header text-bg-primary">
                        <img src="https://ui-avatars.com/api/?name=User&background=random" 
                             class="rounded-circle shadow" alt="User Image">
                        <p>
                            User
                            <small>Member since Jan. 2025</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                        <a href="#" class="btn btn-default btn-flat float-end">Sign out</a>
                    </li>
                </ul>
            </li>
        </ul>

        <!-- Logo Kanan -->
        <div class="navbar-brand-wrapper d-flex align-items-center ms-3">
            <img src="{{ asset('images/MBM.jpeg') }}" alt="Logo Right" class="brand-image" style="height: 40px; width: auto; max-height: 50px;">
        </div>
    </div>
</nav>