<header class="bg-white shadow-md">
    <div class="container mx-auto px-4 py-2 flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
            @can('mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-2">
                <img src="{{ asset('uploads/Logo-02.png') }}" alt="Logo" class="h-10 w-auto object-contain">
            </a>
            @endcan
        </div>

        <!-- Navigation Links -->
        <nav class="hidden md:flex items-center space-x-2">
            @can('mahasiswa')
                <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.pengajuan-judul.index') }}" class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('mahasiswa.pengajuan-judul.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Pengajuan Judul</span>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg {{ request()->routeIs('mahasiswa.jadwal-bimbingan.*') ? 'bg-green-600 text-white shadow-sm' : 'text-gray-700 hover:bg-green-50 hover:text-green-600' }}">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>Jadwal Bimbingan</span>
                    </div>
                </a>

                <a href="{{ route('mahasiswa.bimbingan.index') }}" class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-lg text-gray-700 hover:bg-green-50 hover:text-green-600">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        <span>Bimbingan</span>
                    </div>
                </a>
            @endcan
        </nav>

        <!-- Mobile Menu Button (shown on small screens) -->
        <div class="md:hidden">
            <button type="button" onclick="toggleMobileMenu()" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
        </div>

        <!-- User Info & Dropdown -->
        <div class="relative hidden md:block">
            <div class="flex items-center">
                <div class="mr-2 text-right hidden sm:block">
                    @can('mahasiswa')
                        @if(Auth::user()->mahasiswa)
                            <div class="text-sm font-medium text-gray-700">{{ Auth::user()->mahasiswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->mahasiswa->nim }}</div>
                        @endif
                    @endcan
                </div>

                <button type="button" onclick="toggleDropdown()" class="flex items-center focus:outline-none group" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-gray-300 group-hover:border-green-400 transition-colors duration-200">
                        @if(Auth::user() && Auth::user()->gambar)
                            <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile image" class="h-full w-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <svg class="w-4 h-4 ml-1 text-gray-500 group-hover:text-green-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="userDropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </div>
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <button onclick="confirmLogout()" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50" role="menuitem">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </div>
                </button>

                <!-- Hidden logout form -->
                <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Menu (hidden by default) -->
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-gray-200 py-2 px-4">
        @can('mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('mahasiswa.dashboard') ? 'text-green-600 font-medium' : 'text-gray-700' }}">Dashboard</a>
            <a href="{{ route('mahasiswa.pengajuan-judul.index') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('mahasiswa.pengajuan-judul.*') ? 'text-green-600 font-medium' : 'text-gray-700' }}">Pengajuan Judul</a>
            <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('mahasiswa.jadwal-bimbingan.*') ? 'text-green-600 font-medium' : 'text-gray-700' }}">Jadwal Bimbingan</a>
            <a href="{{ route('mahasiswa.bimbingan.index') }}" class="block py-2 px-4 text-sm {{ request()->routeIs('mahasiswa.bimbingan.*') ? 'text-green-600 font-medium' : 'text-gray-700' }}">Bimbingan</a>

            <div class="border-t border-gray-200 my-2"></div>

            <div class="py-2 px-4">
                @if(Auth::user()->mahasiswa)
                    <div class="text-sm font-medium text-gray-700">{{ Auth::user()->mahasiswa->nama_lengkap }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->mahasiswa->nim }}</div>
                @endif
            </div>

            <a href="{{ route('profile.edit') }}" class="block py-2 px-4 text-sm text-gray-700">Profile</a>
            <button onclick="confirmLogout()" class="block w-full text-left py-2 px-4 text-sm text-red-600">Logout</button>
        @endcan
    </div>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        mobileMenu.classList.toggle('hidden');
    }

    // Close the dropdown when clicking outside
    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.getElementById('user-menu-button');

        if (!dropdown.contains(event.target) && !button.contains(event.target) && !dropdown.classList.contains('hidden')) {
            dropdown.classList.add('hidden');
        }
    });

    // Logout confirmation function
    function confirmLogout() {
        if (confirm('Anda yakin ingin keluar?')) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
