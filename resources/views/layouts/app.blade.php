<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SIMKGIGI - Sistem Informasi Manajemen Klinik Gigi</title>

    <!-- Font Awesome for dashboard icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Inter:300,400,500,600,700" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        :root {
            --primary-color: #1a73e8; /* Dental blue */
            --primary-dark: #0d5bb7;
            --secondary-color: #4dabf7; /* Light blue */
            --success-color: #40c057; /* Green */
            --danger-color: #fa5252; /* Red */
            --warning-color: #fab005; /* Yellow */
            --info-color: #15aabf; /* Cyan */
            --light-color: #f8f9fa;
            --dark-color: #212529;
            --sidebar-bg: #1a73e8; /* Blue sidebar */
            --sidebar-hover: #0d5bb7;
            --sidebar-text: #e9f2ff;
            --sidebar-text-active: #ffffff;
            --border-color: #e2e8f0;
            --sidebar-width: 280px;
            --dental-blue: #1a73e8;
            --dental-light-blue: #e7f1ff;
            --dental-cyan: #15aabf;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #334155;
            overflow-x: hidden;
        }

        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--sidebar-bg) 0%, #0d5bb7 100%);
            color: var(--sidebar-text);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            z-index: 1000;
            transition: transform 0.3s ease;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 2px;
        }

        .sidebar-header {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            color: var(--sidebar-text-active);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .sidebar-brand-icon {
            width: 40px;
            height: 40px;
            background: white;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 1.5rem;
        }

        .sidebar-user {
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-avatar {
            width: 48px;
            height: 48px;
            background: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-details h6 {
            color: var(--sidebar-text-active);
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 0.9rem;
        }

        .user-role {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.2rem 0.6rem;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .sidebar-menu {
            padding: 1rem 0;
            flex: 1;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            padding: 0 1.5rem 0.5rem;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: rgba(255, 255, 255, 0.7);
        }

        .menu-item {
            display: block;
            padding: 0.75rem 1.5rem;
            color: var(--sidebar-text);
            text-decoration: none;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
            position: relative;
        }

        .menu-item:hover {
            background: var(--sidebar-hover);
            color: var(--sidebar-text-active);
            border-left-color: white;
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.1);
            color: var(--sidebar-text-active);
            border-left-color: white;
        }

        .menu-item i {
            width: 20px;
            margin-right: 0.75rem;
            font-size: 1.1rem;
        }

        .menu-item span {
            font-weight: 500;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            min-height: 100vh;
            background: #f8fafc;
        }

        .top-bar {
            background: white;
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .content-area {
            padding: 2rem;
        }

        /* Mobile Sidebar Toggle */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 1100;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 0.5rem;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.3);
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar-toggle {
                display: block;
            }

            .sidebar-overlay.active {
                display: block;
            }

            .main-content {
                margin-left: 0;
            }

            .top-bar {
                padding-left: 4rem;
            }
        }

        /* Guest Layout */
        .guest-layout {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color), var(--dental-cyan));
        }

        .guest-nav {
            position: fixed;
            top: 0;
            right: 0;
            padding: 1rem 2rem;
            z-index: 1000;
        }

        .guest-nav a {
            color: white;
            text-decoration: none;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: background 0.2s ease;
        }

        .guest-nav a:hover {
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body>
<div id="app">
    @guest
        <!-- Guest Layout -->
        <div class="guest-layout">
            <nav class="guest-nav">
                @if (Route::has('login'))
                    <a href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Login
                    </a>
                @endif
                @if (Route::has('register'))
                    <a href="{{ route('register') }}">
                        <i class="bi bi-person-plus"></i> Register
                    </a>
                @endif
            </nav>
            
            <main class="py-4">
                @yield('content')
            </main>
        </div>
    @else
        <!-- Authenticated Layout -->
        <div class="app-container">
            <!-- Mobile Toggle Button -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="bi bi-list"></i>
            </button>

            <!-- Sidebar Overlay for Mobile -->
            <div class="sidebar-overlay" onclick="toggleSidebar()"></div>

            <!-- Sidebar -->
            <aside class="sidebar" id="sidebar">
                <!-- Sidebar Header -->
                <div class="sidebar-header">
                    <a href="{{ url('/') }}" class="sidebar-brand">
                        <div class="sidebar-brand-icon">
                            <i class="bi bi-tooth"></i>
                        </div>
                        SIMKGIGI
                    </a>
                </div>

                <!-- User Info -->
                <div class="sidebar-user">
                    <div class="user-info">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div class="user-details">
                            <h6>{{ Auth::user()->name }}</h6>
                            <span class="user-role">{{ Auth::user()->role }}</span>
                        </div>
                    </div>
                </div>

                    @php
                        $role = Auth::user()->role;
                    @endphp

                    @if ($role === 'admin')
                        <!-- Admin Menu for Klinik Gigi -->
                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <!-- Dashboard -->
                            <div class="menu-section">
                                <div class="menu-section-title">Dashboard</div>
                                <!-- Dashboard Admin -->
                                <a href="/home-admin" class="menu-item">
                                    <i class="bi bi-speedometer2"></i>
                                    <span>Dashboard Admin</span>
                                </a>
                            </div>
                        </nav>
                        <div class="menu-section">
                            <div class="menu-section-title">Manajemen Pengguna</div>
                            <a href="/users" class="menu-item">
                                <i class="bi bi-people"></i>
                                <span>Kelola User</span>
                            </a>
                            <a href="/dokter" class="menu-item">
                                <i class="bi bi-person-badge"></i>
                                <span>Data Dokter Gigi</span>
                            </a>
                        </div>

                        <div class="menu-section">
                            <div class="menu-section-title">Pelayanan Gigi</div>
                            <a href="/jadwal-praktik" class="menu-item">
                                <i class="bi bi-calendar2-week"></i>
                                <span>Jadwal Praktik</span>
                            </a>
                            <a href="/pasien.index" class="menu-item">
                                <i class="bi bi-person-lines-fill"></i>
                                <span>Data Pasien</span>
                            </a>
                            <a href="/pasien-hari-ini" class="menu-item">
                                <i class="bi bi-clipboard-check"></i>
                                <span>Pasien Hari Ini</span>
                            </a>
                        </div>

                        <div class="menu-section">
                            <div class="menu-section-title">Rekam Medis</div>
                            <a href="/rekam-medis" class="menu-item">
                                <i class="bi bi-file-earmark-medical"></i>
                                <span>Rekam Medis Gigi</span>
                            </a>
                            <a href="/obat" class="menu-item">
                                <i class="bi bi-bandaid"></i>
                                <span>Data Obat</span>
                            </a>
                        </div>

                        <div class="menu-section">
                            <div class="menu-section-title">Laporan & Sistem</div>
                            <a href="/pelaporan" class="menu-item">
                                <i class="bi bi-clipboard-data"></i>
                                <span>Laporan</span>
                            </a>
                        </div>

                    @elseif ($role === 'dokter')

                        <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <!-- Dashboard -->
                            <div class="menu-section">
                                <div class="menu-section-title">Dashboard</div>
                                <!-- Dashboard Dokter -->
                                <a href="/home-dokter" class="menu-item">
                                    <i class="bi bi-person-badge"></i>
                                    <span>Dashboard Dokter</span>
                                </a>
                            </div>
                        </nav>

                        <!-- Doctor Menu -->
                        <div class="menu-section">
                            <div class="menu-section-title">Praktik Gigi</div>
                            <a href="/jadwal" class="menu-item">
                                <i class="bi bi-calendar2-week"></i>
                                <span>Jadwal Praktik</span>
                            </a>
                            <a href="/pasien" class="menu-item">
                                <i class="bi bi-person-vcard"></i>
                                <span>Data Pasien</span>
                            </a>
                            <a href="/anamnesa" class="menu-item">
                                <i class="bi bi-file-earmark-medical"></i>
                                <span>Anamnesa</span>
                            </a>
                        </div>

                    @elseif ($role === 'pengguna')
                    <!-- Sidebar Menu -->
                        <nav class="sidebar-menu">
                            <!-- Dashboard -->
                            <div class="menu-section">
                                <div class="menu-section-title">Dashboard</div>
                                <!-- Dashboard Pasien -->
                                <a href="/home-pasien" class="menu-item">
                                    <i class="bi bi-house-heart"></i>
                                    <span>Dashboard Pasien</span>
                                </a>
                            </div>
                        </nav>
                        <!-- User Menu -->
                        <div class="menu-section">
                            <div class="menu-section-title">Layanan Gigi</div>
                            <a href="/buat-janji" class="menu-item">
                                <i class="bi bi-calendar-plus"></i>
                                <span>Buat Janji Temu</span>
                            </a>
                            <a href="/riwayat" class="menu-item">
                                <i class="bi bi-clock-history"></i>
                                <span>Riwayat Perawatan</span>
                            </a>
                            <a href="/pembayaran" class="menu-item">
                                <i class="bi bi-credit-card"></i>
                                <span>Pembayaran</span>
                            </a>
                        </div>

                        <div class="menu-section">
                            <div class="menu-section-title">Akun Saya</div>
                            <a href="/profil" class="menu-item">
                                <i class="bi bi-person-circle"></i>
                                <span>Profil Saya</span>
                            </a>
                        </div>
                    @endif
                </nav>

                <!-- Sidebar Footer -->
                <div class="sidebar-footer">
                    <a href="{{ route('logout') }}" class="logout-btn"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="main-content">
                <div class="top-bar">
                    <h5 class="mb-0">Selamat datang, {{ Auth::user()->name }}!</h5>
                </div>
                <div class="content-area">
                    @yield('content')
                </div>
            </div>
        </div>
    @endguest
</div>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.querySelector('.sidebar-overlay');
        
        sidebar.classList.toggle('active');
        overlay.classList.toggle('active');
    }

    // Active menu highlighting
    document.addEventListener('DOMContentLoaded', function() {
        const currentPath = window.location.pathname;
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentPath) {
                item.classList.add('active');
            }
        });
    });

    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.sidebar-toggle');
        
        if (window.innerWidth <= 768 && 
            !sidebar.contains(event.target) && 
            !toggle.contains(event.target) && 
            sidebar.classList.contains('active')) {
            toggleSidebar();
        }
    });
</script>

<!-- jQuery + DataTables JS -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

</body>
</html>