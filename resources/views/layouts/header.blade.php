<header class="bg-white shadow">
    <div class="container mx-auto px-4 flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
            @can('mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </a>
            @endcan
        </div>

        <!-- Navigation Links -->
        <nav class="hidden md:flex space-x-1">
            @can('mahasiswa')
                <a href="{{ route('mahasiswa.dashboard') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.dashboard') ? 'bg-green-600 text-white rounded-full' : 'text-gray-700 hover:text-gray-900' }}">Dashboard</a>

                <a href="{{ route('mahasiswa.pengajuan-judul.index') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.pengajuan-judul.*') ? 'bg-green-600 text-white rounded-full' : 'text-gray-700 hover:text-gray-900' }}">Pengajuan Judul</a>

                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="px-4 py-2 text-sm font-medium {{ request()->routeIs('mahasiswa.jadwal-bimbingan.*') ? 'bg-green-600 text-white rounded-full' : 'text-gray-700 hover:text-gray-900' }}">Jadwal Bimbingan</a>

                <a href="#" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Bimbingan</a>
            @endcan

        </nav>

        <!-- User Info & Dropdown -->
        <div class="relative">
            <div class="flex items-center">
                <div class="mr-2 text-right hidden sm:block">
                    @can('mahasiswa')
                        @if(Auth::user()->mahasiswa)
                            <div class="text-sm font-medium text-gray-700">{{ Auth::user()->mahasiswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ Auth::user()->mahasiswa->nim }}</div>
                        @endif
                    @endcan
                </div>

                <button type="button" onclick="toggleDropdown()" class="flex items-center focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                    <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border-2 border-gray-300">
                        @if(Auth::user() && Auth::user()->gambar)
                            <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile image" class="h-full w-full object-cover">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        @endif
                    </div>
                    <svg class="w-4 h-4 ml-1 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Dropdown menu -->
            <div id="userDropdown" class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Profile
                    </div>
                </a>
                <div class="border-t border-gray-100 my-1"></div>
                <button onclick="confirmLogout()" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100" role="menuitem">
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
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
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
