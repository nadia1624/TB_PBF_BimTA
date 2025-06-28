@extends('layouts.dosen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Riwayat Bimbingan</h1>

    <!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <!-- Total Riwayat Card -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-blue-50 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-600">Total Riwayat</h4>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalRiwayat }}</p>
                <p class="text-xs text-gray-500">Semua riwayat bimbingan</p>
            </div>
            <div class="ml-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulan Ini Card -->
    <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-green-50 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-600">Bulan Ini</h4>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $riwayatBulanIni }}</p>
                <p class="text-xs text-gray-500">Bimbingan bulan ini</p>
            </div>
            <div class="ml-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Bimbingan Online Card -->
    {{-- <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center mb-2">
                    <div class="p-2 bg-purple-50 rounded-lg mr-3">
                        <svg class="w-6 h-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-medium text-gray-600">Bimbingan Online</h4>
                </div>
                <p class="text-3xl font-bold text-gray-900 mb-1">{{ $riwayatOnline }}</p>
                <p class="text-xs text-gray-500">Total bimbingan online</p>
            </div>
            <div class="ml-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center shadow-lg">
                    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
        </div>
    </div> --}}
</div>

<!-- Enhanced Filter dan Search Section -->
<div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-8">
    <!-- Filter Form Section -->
    <div class="p-6">
        <form method="GET" action="{{ route('dosen.riwayat-bimbingan') }}" id="filterForm" class="space-y-6">
            <!-- Search Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Pencarian
                    </label>
                    <div class="relative">
                        <input type="text"
                               name="search"
                               id="searchInput"
                               value="{{ request('search') }}"
                               placeholder="Ketik untuk mencari..."
                               class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 bg-gray-50 focus:bg-white">
                        <svg class="w-5 h-5 text-gray-400 absolute left-4 top-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <!-- Loading indicator untuk search -->
                        <div id="searchLoading" class="hidden absolute right-4 top-4">
                            <svg class="animate-spin w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Metode Bimbingan
                    </label>
                    <select name="metode" id="metodeSelect" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 bg-gray-50 focus:bg-white">
                        <option value="">🔍 Semua Metode</option>
                        <option value="online" {{ request('metode') == 'online' ? 'selected' : '' }}>💻 Online</option>
                        <option value="offline" {{ request('metode') == 'offline' ? 'selected' : '' }}>🏢 Offline</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-medium text-gray-700 flex items-center">
                        <svg class="w-4 h-4 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Tanggal
                    </label>
                    <input type="date"
                           name="start_date"
                           id="dateInput"
                           value="{{ request('start_date') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors duration-200 bg-gray-50 focus:bg-white">
                </div>
            </div>

            <!-- Status Information -->
            <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                <div class="flex items-center space-x-4">
                    <!-- Filter Status -->
                    {{-- <div id="filterStatus" class="flex items-center text-sm text-gray-600">
                        <svg class="w-4 h-4 mr-2 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Filter otomatis aktif</span>
                    </div> --}}

                    <!-- Active Filters Display -->
                    <div id="activeFilters" class="flex flex-wrap gap-2"></div>
                </div>

                <div class="flex space-x-2">
                    <!-- Reset Filter Button -->
                    <a href="{{ route('dosen.riwayat-bimbingan') }}"
                       class="flex items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 font-medium rounded-lg hover:bg-gray-200 focus:ring-4 focus:ring-gray-300 transition-all duration-200 border border-gray-300">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset
                    </a>

                    <!-- Export Button -->
                    {{-- <button type="button"
                            onclick="window.print()"
                            class="flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 font-medium rounded-lg hover:bg-blue-200 focus:ring-4 focus:ring-blue-300 transition-all duration-200 border border-blue-300">
                        <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Cetak
                    </button> --}}
                </div>
            </div>

            <!-- Quick Filter Tags -->
            {{-- <div class="flex flex-wrap gap-2 pt-2">
                <span class="text-sm text-gray-600 font-medium">Filter Cepat:</span>
                <button type="button"
                        onclick="setQuickFilter('today')"
                        class="px-3 py-1 text-xs bg-blue-100 text-blue-700 rounded-full hover:bg-blue-200 transition-colors duration-200">
                    Hari Ini
                </button>
                <button type="button"
                        onclick="setQuickFilter('this_week')"
                        class="px-3 py-1 text-xs bg-green-100 text-green-700 rounded-full hover:bg-green-200 transition-colors duration-200">
                    Minggu Ini
                </button>
                <button type="button"
                        onclick="setQuickFilter('this_month')"
                        class="px-3 py-1 text-xs bg-purple-100 text-purple-700 rounded-full hover:bg-purple-200 transition-colors duration-200">
                    Bulan Ini
                </button>
                <button type="button"
                        onclick="setQuickFilter('online')"
                        class="px-3 py-1 text-xs bg-orange-100 text-orange-700 rounded-full hover:bg-orange-200 transition-colors duration-200">
                    Online Saja
                </button>
                <button type="button"
                        onclick="setQuickFilter('offline')"
                        class="px-3 py-1 text-xs bg-pink-100 text-pink-700 rounded-full hover:bg-pink-200 transition-colors duration-200">
                    Offline Saja
                </button>
            </div> --}}
        </form>
    </div>
</div>

<!-- Riwayat Bimbingan Section -->
<div class="bg-white p-6 rounded-lg shadow-md">
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-xl font-bold">Riwayat Bimbingan Selesai</h2>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="py-3 px-4 text-left">MAHASISWA</th>
                    <th class="py-3 px-4 text-left">JUDUL</th>
                    <th class="py-3 px-4 text-left">METODE</th>
                    <th class="py-3 px-4 text-left">TANGGAL</th>
                    <th class="py-3 px-4 text-left">WAKTU</th>
                    <th class="py-3 px-4 text-left">KETERANGAN</th>
                    <th class="py-3 px-4 text-left">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatBimbingan as $jadwal)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-3 px-4">
                        <div>
                            <div class="font-semibold">{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap ?? $jadwal->pengajuanJudul->mahasiswa->nama ?? 'Nama tidak tersedia' }}</div>
                            <div class="text-sm text-gray-600">{{ $jadwal->pengajuanJudul->mahasiswa->nim ?? 'NIM tidak tersedia' }}</div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="max-w-xs truncate" title="{{ $jadwal->pengajuanJudul->judul ?? 'Judul tidak tersedia' }}">
                            {{ Str::limit($jadwal->pengajuanJudul->judul ?? 'Judul tidak tersedia', 50) }}
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 rounded-full text-xs {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800' }}">
                            {{ $jadwal->metode == 'online' ? 'Online' : 'Offline' }}
                        </span>
                    </td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d/m/Y') }}</td>
                    <td class="py-3 px-4">{{ \Carbon\Carbon::parse($jadwal->waktu_pengajuan)->format('H:i') }} WIB</td>
                    <td class="py-3 px-4">
                        <div class="max-w-xs truncate" title="{{ $jadwal->keterangan ?? 'Tidak ada keterangan' }}">
                            {{ $jadwal->keterangan ? Str::limit($jadwal->keterangan, 30) : 'Tidak ada keterangan' }}
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex space-x-2">
                            <button class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors detail-btn"
                                    data-id="{{ $jadwal->id }}"
                                    data-mahasiswa="{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap ?? $jadwal->pengajuanJudul->mahasiswa->nama ?? 'Nama tidak tersedia' }}"
                                    data-nim="{{ $jadwal->pengajuanJudul->mahasiswa->nim ?? 'NIM tidak tersedia' }}"
                                    data-bab="{{ $jadwal->dokumenOnline ? ($jadwal->dokumenOnline->bab ?? 'Tidak tersedia') : 'Tidak tersedia' }}"
                                    data-keterangan-dosen="{{ $jadwal->dokumenOnline ? ($jadwal->dokumenOnline->keterangan_dosen ?? 'Tidak ada keterangan dosen') : 'Tidak ada keterangan dosen' }}"
                                    data-keterangan-mahasiswa="{{ $jadwal->dokumenOnline ? ($jadwal->dokumenOnline->keterangan_mahasiswa ?? 'Tidak ada keterangan mahasiswa') : 'Tidak ada keterangan mahasiswa' }}"
                                    data-tanggal="{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d/m/Y') }}"
                                    data-waktu="{{ \Carbon\Carbon::parse($jadwal->waktu_pengajuan)->format('H:i') }}"
                                    data-metode="{{ $jadwal->metode }}"
                                    data-dokumen-mahasiswa="{{ $jadwal->dokumenOnline && $jadwal->dokumenOnline->dokumen_mahasiswa ? route('dosen.dokumen.online.download', $jadwal->dokumenOnline->id) : '' }}"
                                    data-dokumen-dosen="{{ $jadwal->dokumenOnline && $jadwal->dokumenOnline->dokumen_dosen ? route('dosen.dokumen.online.download.dosen', $jadwal->dokumenOnline->id) : '' }}"
                                    title="Detail">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                            <a href="{{ route('dosen.dokumen.online') }}" class="bg-green-500 text-white p-2 rounded-md hover:bg-green-600 transition-colors" title="Lihat Dokumen">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="border-t">
                    <td colspan="7" class="py-6 text-center text-gray-500">
                        <div class="flex flex-col items-center">
                            <svg class="w-12 h-12 text-gray-400 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p>Tidak ada riwayat bimbingan yang selesai</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($riwayatBimbingan->hasPages())
    <div class="mt-6">
        {{ $riwayatBimbingan->links() }}
    </div>
    @endif
</div>

<!-- Modal untuk detail jadwal -->
<div id="detailJadwalModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="detailModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true"></span>

        <!-- Modal panel dengan animasi yang lebih smooth -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-scale-up">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-white" id="modal-title">
                            Detail Jadwal Bimbingan
                        </h3>
                    </div>
                    <button type="button" id="closeDetailJadwalModalX" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <div class="space-y-4">
                    <!-- Mahasiswa Info -->
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-blue-500">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center mt-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Mahasiswa</h4>
                            <p id="modalMahasiswa" class="mt-1 text-lg font-semibold text-gray-900"></p>
                            <p id="modalNim" class="text-sm text-gray-600"></p>
                        </div>
                    </div>

                    <!-- Document Info -->
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-yellow-500" id="documentInfoSection">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-yellow-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Dokumen</h4>
                            <p id="modalBab" class="mt-1 text-lg font-semibold text-gray-900"></p>
                            <p id="modalKeteranganMahasiswa" class="mt-2 text-sm text-gray-600"></p>
                            <p id="modalKeteranganDosen" class="mt-2 text-sm text-gray-600"></p>
                            <div class="mt-2 flex justify-end space-x-2" id="documentButtons">
                                <a id="modalDokumenMahasiswaView" href="#" class="inline-flex items-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-md transition-colors" target="_blank" style="display: none;">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542-7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Dokumen Mahasiswa
                                </a>
                                <a id="modalDokumenMahasiswa" href="#" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-md hover:bg-blue-200 transition-colors" style="display: none;">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Dokumen Mahasiswa
                                </a>
                                <a id="modalDokumenDosenView" href="#" class="inline-flex items-center px-3 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium rounded-md transition-colors" target="_blank" style="display: none;">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542-7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Dokumen Dosen
                                </a>
                                <a id="modalDokumenDosen" href="#" class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-md hover:bg-green-200 transition-colors" style="display: none;">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Dokumen Dosen
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Jadwal Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Tanggal -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-green-500">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Tanggal</h4>
                                <p id="modalTanggalJadwal" class="mt-1 text-lg font-semibold text-gray-900"></p>
                            </div>
                        </div>

                        <!-- Waktu -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-purple-500">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Waktu</h4>
                                <p id="modalWaktuJadwal" class="mt-1 text-lg font-semibold text-gray-900"></p>
                            </div>
                        </div>

                        <!-- Metode -->
                        <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-orange-500">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Metode</h4>
                                <p id="modalMetodeJadwal" class="mt-1 text-lg font-semibold text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" id="closeDetailJadwalModal" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('filterForm');
    const searchInput = document.getElementById('searchInput');
    const metodeSelect = document.getElementById('metodeSelect');
    const dateInput = document.getElementById('dateInput');
    const searchLoading = document.getElementById('searchLoading');
    const activeFiltersContainer = document.getElementById('activeFilters');

    let searchTimeout;

    // Function to submit form
    function submitForm() {
        form.submit();
    }

    // Function to show loading indicator
    function showLoading() {
        searchLoading.classList.remove('hidden');
    }

    // Function to hide loading indicator
    function hideLoading() {
        searchLoading.classList.add('hidden');
    }

    // Auto submit for search with debounce
    searchInput.addEventListener('input', function() {
        showLoading();
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            hideLoading();
            submitForm();
        }, 800); // Wait 800ms after user stops typing
    });

    // Auto submit for select changes
    metodeSelect.addEventListener('change', function() {
        submitForm();
    });

    // Auto submit for date changes
    dateInput.addEventListener('change', function() {
        submitForm();
    });

    // Update active filters display
    function updateActiveFilters() {
        activeFiltersContainer.innerHTML = '';

        const searchValue = searchInput.value.trim();
        const metodeValue = metodeSelect.value;
        const dateValue = dateInput.value;

        if (searchValue) {
            addFilterTag('Pencarian: ' + searchValue, 'blue');
        }

        if (metodeValue) {
            const metodeText = metodeValue === 'online' ? 'Online' : 'Offline';
            addFilterTag('Metode: ' + metodeText, 'green');
        }

        if (dateValue) {
            addFilterTag('Tanggal: ' + dateValue, 'purple');
        }
    }

    function addFilterTag(text, color) {
        const tag = document.createElement('span');
        tag.className = `px-2 py-1 text-xs bg-${color}-100 text-${color}-700 rounded-full`;
        tag.textContent = text;
        activeFiltersContainer.appendChild(tag);
    }

    // Quick filter functions
    window.setQuickFilter = function(type) {
        const today = new Date();

        switch(type) {
            case 'today':
                dateInput.value = today.toISOString().split('T')[0];
                metodeSelect.value = '';
                break;
            case 'this_week':
                const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()));
                dateInput.value = startOfWeek.toISOString().split('T')[0];
                metodeSelect.value = '';
                break;
            case 'this_month':
                const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
                dateInput.value = startOfMonth.toISOString().split('T')[0];
                metodeSelect.value = '';
                break;
            case 'online':
                metodeSelect.value = 'online';
                break;
            case 'offline':
                metodeSelect.value = 'offline';
                break;
        }

        submitForm();
    };

    // Initial update of active filters
    updateActiveFilters();

    // Update active filters when form changes
    [searchInput, metodeSelect, dateInput].forEach(element => {
        element.addEventListener('change', updateActiveFilters);
        element.addEventListener('input', updateActiveFilters);
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Elements untuk modal detail jadwal
    const detailJadwalModal = document.getElementById('detailJadwalModal');
    const closeDetailJadwalModal = document.getElementById('closeDetailJadwalModal');
    const closeDetailJadwalModalX = document.getElementById('closeDetailJadwalModalX');
    const detailModalOverlay = document.getElementById('detailModalOverlay');
    const documentInfoSection = document.getElementById('documentInfoSection');
    const documentButtons = document.getElementById('documentButtons');

    // Get all detail buttons
    const detailButtons = document.querySelectorAll('.detail-btn');

    // Event listeners for detail buttons
    detailButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const mahasiswa = this.getAttribute('data-mahasiswa');
            const nim = this.getAttribute('data-nim');
            const bab = this.getAttribute('data-bab');
            const keteranganDosen = this.getAttribute('data-keterangan-dosen');
            const keteranganMahasiswa = this.getAttribute('data-keterangan-mahasiswa');
            const tanggal = this.getAttribute('data-tanggal');
            const waktu = this.getAttribute('data-waktu');
            const metode = this.getAttribute('data-metode');
            const dokumenMahasiswa = this.getAttribute('data-dokumen-mahasiswa');
            const dokumenDosen = this.getAttribute('data-dokumen-dosen');

            // Set data ke modal
            document.getElementById('modalMahasiswa').textContent = mahasiswa;
            document.getElementById('modalNim').textContent = nim;
            document.getElementById('modalBab').textContent = bab;
            document.getElementById('modalKeteranganDosen').textContent = keteranganDosen;
            document.getElementById('modalKeteranganMahasiswa').textContent = keteranganMahasiswa;
            document.getElementById('modalTanggalJadwal').textContent = tanggal;
            document.getElementById('modalWaktuJadwal').textContent = waktu + ' WIB';
            document.getElementById('modalMetodeJadwal').textContent = metode.charAt(0).toUpperCase() + metode.slice(1);

            // Handle visibility of document section and buttons
            const dokumenMahasiswaLink = document.getElementById('modalDokumenMahasiswa');
            const dokumenDosenLink = document.getElementById('modalDokumenDosen');
            const dokumenMahasiswaViewLink = document.getElementById('modalDokumenMahasiswaView');
            const dokumenDosenViewLink = document.getElementById('modalDokumenDosenView');

            if (metode === 'offline') {
                // Sembunyikan section dokumen untuk metode offline
                documentInfoSection.style.display = 'none';
            } else {
                // Tampilkan section dokumen untuk metode online
                documentInfoSection.style.display = 'flex';

                // Handle download and view buttons visibility
                dokumenMahasiswaLink.style.display = dokumenMahasiswa ? 'inline-flex' : 'none';
                dokumenDosenLink.style.display = dokumenDosen ? 'inline-flex' : 'none';
                dokumenMahasiswaViewLink.style.display = dokumenMahasiswa ? 'inline-flex' : 'none';
                dokumenDosenViewLink.style.display = dokumenDosen ? 'inline-flex' : 'none';

                // Set href untuk tombol download
                if (dokumenMahasiswa) {
                    dokumenMahasiswaLink.href = dokumenMahasiswa;
                    dokumenMahasiswaViewLink.href = dokumenMahasiswa.replace('download', 'view');
                }
                if (dokumenDosen) {
                    dokumenDosenLink.href = dokumenDosen;
                    dokumenDosenViewLink.href = dokumenDosen.replace('download.dosen', 'view.dosen');
                }
            }

            // Show modal
            detailJadwalModal.classList.remove('hidden');
        });
    });

    // Close modal function
    function closeDetailJadwalModalHandler() {
        detailJadwalModal.classList.add('hidden');
        // Reset visibility of document section when closing modal
        documentInfoSection.style.display = 'flex';
    }

    // Close modal event listeners
    closeDetailJadwalModal.addEventListener('click', closeDetailJadwalModalHandler);
    closeDetailJadwalModalX.addEventListener('click', closeDetailJadwalModalHandler);
    detailModalOverlay.addEventListener('click', closeDetailJadwalModalHandler);

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !detailJadwalModal.classList.contains('hidden')) {
            closeDetailJadwalModalHandler();
        }
    });
});
</script>
@endpush
@endsection
