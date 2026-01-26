<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel')) | GA System</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" crossorigin="anonymous">
    
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" crossorigin="anonymous">
    
    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css" crossorigin="anonymous">

    <!-- Custom Responsive Styles -->
    <style>
        /* Base responsive adjustments */
        :root {
            --sidebar-width: 250px;
            --sidebar-mini-width: 4.6rem;
        }
        
        /* Smooth transitions */
        .app-wrapper, .app-main, .app-sidebar, .app-header {
            transition: margin-left 0.3s ease-in-out, width 0.3s ease-in-out;
        }
        
        /* Content area */
        .app-content {
            padding: 1rem;
        }
        
        /* Cards */
        .card {
            margin-bottom: 1rem;
            border: none;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 0.75rem 1rem;
        }
        
        /* Tables */
        .table {
            margin-bottom: 0;
        }
        
        .table th {
            border-top: none;
            font-weight: 600;
            font-size: 0.85rem;
        }
        
        .table td {
            vertical-align: middle;
            font-size: 0.85rem;
        }
        
        /* Responsive table wrapper */
        .table-responsive-stack {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        /* Small box */
        .small-box {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        
        .small-box .small-box-footer {
            background: rgba(0,0,0,0.1);
            padding: 5px 0;
            text-align: center;
            color: inherit;
            text-decoration: none;
            display: block;
        }
        
        /* Info box */
        .info-box {
            border-radius: 0.5rem;
            min-height: 80px;
        }
        
        /* Sidebar improvements */
        .sidebar-menu .nav-link {
            padding: 0.6rem 1rem;
            font-size: 0.9rem;
        }
        
        .sidebar-menu .nav-icon {
            font-size: 1.1rem;
            width: 1.6rem;
        }
        
        /* Badge in navbar */
        .navbar-badge {
            font-size: 0.6rem;
            padding: 2px 4px;
            position: absolute;
            top: 5px;
            right: 3px;
        }
        
        /* Mobile adjustments */
        @media (max-width: 991.98px) {
            .app-content {
                padding: 0.75rem;
            }
            
            .content-header {
                padding: 0.5rem 0;
            }
            
            .content-header h3 {
                font-size: 1.25rem;
            }
            
            .breadcrumb {
                font-size: 0.8rem;
                margin-bottom: 0;
            }
        }
        
        @media (max-width: 767.98px) {
            .app-content {
                padding: 0.5rem;
            }
            
            .card-header {
                padding: 0.5rem 0.75rem;
            }
            
            .card-body {
                padding: 0.75rem;
            }
            
            .card-footer {
                padding: 0.5rem;
            }
            
            .btn {
                padding: 0.35rem 0.75rem;
                font-size: 0.8rem;
            }
            
            /* Hide text on small screens, show only icons */
            .nav-link .d-lg-inline {
                display: none !important;
            }
        }
        
        @media (max-width: 575.98px) {
            .app-content {
                padding: 0.25rem;
            }
            
            .content-header h3 {
                font-size: 1.1rem;
            }
            
            .small-box .inner h3 {
                font-size: 1.5rem;
            }
            
            .small-box .inner p {
                font-size: 0.75rem;
            }
            
            .info-box {
                min-height: 70px;
            }
            
            .info-box .info-box-icon {
                width: 50px;
            }
            
            .info-box-number {
                font-size: 1.1rem;
            }
            
            .info-box-text {
                font-size: 0.75rem;
            }
        }
        
        /* Print styles */
        @media print {
            .app-sidebar, .app-header, .app-footer, .btn, .card-footer {
                display: none !important;
            }
            .app-main {
                margin-left: 0 !important;
            }
        }
    </style>

    @stack('styles')
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        
        <!-- Header -->
        @include('layouts.partials.header')
        
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')
        
        <!-- Main Content -->
        <main class="app-main">
            @hasSection('content-header')
                <div class="app-content-header">
                    <div class="container-fluid">
                        @yield('content-header')
                    </div>
                </div>
            @endif
            
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        @include('layouts.partials.footer')
        
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/js/adminlte.min.js" crossorigin="anonymous"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // OverlayScrollbars for sidebar
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: 'os-theme-light',
                        autoHide: 'leave',
                        clickScroll: true,
                    },
                });
            }
            
            // Close sidebar on mobile when clicking outside
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 992) {
                    const sidebar = document.querySelector('.app-sidebar');
                    const sidebarToggle = document.querySelector('[data-lte-toggle="sidebar"]');
                    
                    if (sidebar && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        document.body.classList.remove('sidebar-open');
                    }
                }
            });
            
            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    if (window.innerWidth >= 992) {
                        document.body.classList.remove('sidebar-open');
                    }
                }, 250);
            });
        });
    </script>

    @stack('scripts')
</body>
</html>