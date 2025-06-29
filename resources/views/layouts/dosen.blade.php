<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .sidebar-gradient {
            background: linear-gradient(135deg, #638B35 0%, #4a6b28 50%, #3d5721 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .menu-item {
            position: relative;
            overflow: hidden;
        }
        .menu-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        .menu-item:hover::before {
            left: 100%;
        }
        .active-menu {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #ffffff;
        }
        .scroll-fade {
            mask-image: linear-gradient(to bottom, transparent 0%, black 5%, black 95%, transparent 100%);
            -webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 5%, black 95%, transparent 100%);
        }
    </style>
</head>
<body class="font-inter antialiased bg-gray-50">
    <!-- Mobile Menu Button -->
    <button
        data-drawer-target="logo-sidebar"
        data-drawer-toggle="logo-sidebar"
        aria-controls="logo-sidebar"
        type="button"
        class="fixed top-4 left-4 z-50 inline-flex items-center p-3 text-sm text-gray-600 rounded-xl lg:hidden hover:bg-white hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-200 transition-all duration-300 bg-white/80 backdrop-blur-sm"
    >
        <span class="sr-only">Open sidebar</span>
        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
            <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
        </svg>
    </button>

    <!-- Sidebar -->
    <aside
        id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-72 h-screen transition-transform -translate-x-full lg:translate-x-0"
        aria-label="Sidebar"
    >
        <div class="h-full p-4 sidebar-gradient">
            <div class="h-full flex flex-col rounded-2xl glass-effect shadow-2xl">

                <!-- Header Section -->
                <div class="p-6 text-center border-b border-white/20">
                    <div class="mb-4">
                        <img src="/uploads/logo.png" class="h-16 mx-auto mb-3 drop-shadow-lg" alt="BimTa Logo" />
                        <img src="/uploads/namelogo.png" class="h-8 mx-auto filter brightness-0 invert" alt="BimTa Name" />
                    </div>

                    <!-- User Profile -->
                    <div class="mt-6 p-4 rounded-xl glass-effect">
                        <a href="{{ route('dosen.profile') }}" class="flex items-center space-x-3 group transition-all duration-200 hover:bg-white/10 rounded-lg p-2 -m-2">
                            <div class="relative">
                                <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center ring-2 ring-white/30 group-hover:ring-white/50 transition-all duration-200">
                                    @if(Auth::user()->dosen && Auth::user()->dosen->gambar && Storage::disk('public')->exists(Auth::user()->dosen->gambar))
                                        <img src="{{ Storage::url(Auth::user()->dosen->gambar) }}"
                                            alt="Profile Picture"
                                            class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <svg class="w-7 h-7 text-white group-hover:text-white/90 transition-colors duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white group-hover:bg-green-300 transition-colors duration-200"></div>
                            </div>
                            <div class="flex-1 text-left">
                                <p class="text-sm font-semibold text-white truncate group-hover:text-white/90 transition-colors duration-200">
                                    {{ Auth::user()->dosen->nama_lengkap ?? 'Nama Tidak Tersedia' }}
                                </p>
                                <p class="text-xs text-white/70 truncate group-hover:text-white/80 transition-colors duration-200">
                                    {{ Auth::user()->dosen->nip ?? 'NIP Tidak Tersedia' }}
                                </p>
                            </div>
                            <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Navigation Menu -->
                <nav class="flex-1 px-4 py-6 scroll-fade overflow-y-auto">
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('dosen.dashboard') }}"
                               class="menu-item flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/10 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 22 21">
                                        <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                                        <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Dashboard</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('dosen/pengajuanjudul') }}"
                               class="menu-item flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/10 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 18 18">
                                        <path d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Pengajuan Judul</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('dosen/jadwal-bimbingan') }}"
                               class="menu-item flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/10 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm14-7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm-5-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4Z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Jadwal Bimbingan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ url('dosen/riwayat-bimbingan') }}"
                               class="menu-item flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/10 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Riwayat Bimbingan</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('dosen.dokumen.online') }}"
                               class="menu-item flex items-center px-4 py-3 text-white rounded-xl hover:bg-white/10 transition-all duration-300 group">
                                <div class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors duration-300">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 18">
                                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z"/>
                                        <path d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z"/>
                                        <path d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">Dokumen Bimbingan</span>
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Footer Section -->
                <div class="p-4 border-t border-white/20">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full flex items-center px-4 py-3 text-white rounded-xl hover:bg-red-500/20 hover:border-red-400 transition-all duration-300 group border border-white/20">
                            <div class="w-10 h-10 bg-red-500/20 rounded-lg flex items-center justify-center mr-3 group-hover:bg-red-500/30 transition-colors duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                            </div>
                            <span class="font-medium">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="lg:ml-72 min-h-screen bg-gray-50">
        <div class="p-6">
            <!-- Flash Messages -->
            @if (session('success'))
                <div id="success-alert" class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                        <button class="ml-auto text-green-600 hover:text-green-800" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="error-alert" class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl shadow-sm" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                        <button class="ml-auto text-red-600 hover:text-red-800" onclick="this.parentElement.parentElement.remove()">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("logo-sidebar");
            const toggleButton = document.querySelector("[data-drawer-toggle]");
            const overlay = document.createElement('div');

            // Create overlay for mobile
            overlay.className = 'fixed inset-0 bg-black/50 z-30 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300';
            document.body.appendChild(overlay);

            function toggleSidebar() {
                const isOpen = !sidebar.classList.contains('-translate-x-full');

                if (isOpen) {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('opacity-0', 'pointer-events-none');
                    overlay.classList.remove('opacity-100');
                } else {
                    sidebar.classList.remove('-translate-x-full');
                    overlay.classList.remove('opacity-0', 'pointer-events-none');
                    overlay.classList.add('opacity-100');
                }
            }

            toggleButton.addEventListener("click", toggleSidebar);
            overlay.addEventListener("click", toggleSidebar);

            // Auto hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('[id$="-alert"]');
                alerts.forEach(alert => {
                    if (alert) {
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => alert.remove(), 300);
                    }
                });
            }, 5000);

            // Add active state to current menu item
            const currentPath = window.location.pathname;
            const menuLinks = document.querySelectorAll('nav a');

            menuLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath ||
                    (currentPath.includes(link.getAttribute('href')) && link.getAttribute('href') !== '/')) {
                    link.classList.add('active-menu');
                }
            });
        });
    </script>
</body>
</html>
