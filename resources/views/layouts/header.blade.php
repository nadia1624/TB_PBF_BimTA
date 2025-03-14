<header class="bg-white shadow">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between">
        <!-- Logo -->
        <div class="flex items-center">
            @can('mahasiswa')
            <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center">
                <div class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            </a>
            @endcan
        </div>

        <!-- Navigation -->
        <nav class="flex-1 px-8">
            <div class="flex space-x-4">
                @can('mahasiswa')
                <a href="{{ route('mahasiswa.dashboard') }}" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Dashboard</a>
                @endcan

                @can('mahasiswa')
                    <a href="{{route('pengajuan-judul')}}"  class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Pengajuan Judul</a>
                    <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="px-3 py-2 bg-green-600 text-white rounded-md text-sm font-medium">Jadwal Bimbingan</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Bimbingan</a>
                @endcan

                @can('dosen')
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Pengajuan TA</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Jadwal Bimbingan</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Bimbingan</a>
                @endcan

                @can('admin')
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Manajemen User</a>
                    <a href="#" class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900">Pengaturan</a>
                @endcan
            </div>
        </nav>

        <!-- User dropdown -->
        <div class="flex items-center">
            <div class="relative ml-3">
                <div>
                    <button type="button" class="flex items-center max-w-xs text-sm bg-gray-200 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open user menu</span>
                        @can('mahasiswa')
                            @if(Auth::user()->mahasiswa)
                                <span class="mr-2 text-gray-700">{{ Auth::user()->mahasiswa->nama_lengkap }}</span>
                                <span class="text-xs text-gray-500 mr-1">[{{ Auth::user()->mahasiswa->nim }}]</span>
                            @endif
                        @endcan

                        @can('dosen')
                            @if(Auth::user()->dosen)
                                <span class="mr-2 text-gray-700">{{ Auth::user()->dosen->nama_lengkap }}</span>
                                <span class="text-xs text-gray-500 mr-1">[{{ Auth::user()->dosen->nip }}]</span>
                            @endif
                        @endcan

                        <div class="h-8 w-8 rounded-full bg-gray-300 flex items-center justify-center overflow-hidden">
                            @if(Auth::user() && Auth::user()->gambar)
                                <img src="{{ asset('storage/' . Auth::user()->gambar) }}" alt="Profile image">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            @endif
                        </div>
                    </button>
                </div>

                <!-- Dropdown menu, show/hide based on menu state (not implemented here, would need JavaScript) -->
                <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">Log out</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
