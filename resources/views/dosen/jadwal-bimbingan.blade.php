@extends('layouts.dosen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Jadwal Bimbingan</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <!-- Bimbingan Hari Ini Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Bimbingan Hari Ini</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $todaySchedulesCount }}</p>
                    <p class="text-xs text-gray-500">Jadwal untuk hari ini</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Konfirmasi Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-orange-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Menunggu Konfirmasi</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $pendingSchedulesCount }}</p>
                    <p class="text-xs text-gray-500">Jadwal menunggu persetujuan</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Selesai Card -->
        {{-- <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Selesai</p>
                    <h3 class="text-4xl font-bold">{{ $completedSchedulesCount }}</h3>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Jadwal Hari Ini Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-bold">Jadwal Hari Ini</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse($jadwalHariIni->where('status', 'diterima') as $jadwal)
            <div class="border rounded-lg p-4 {{ $jadwal->metode == 'online' ? 'border-blue-200 bg-blue-50' : 'border-green-200 bg-green-50' }}">
                <!-- Header Card dengan Status Badge -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 rounded-full {{ $jadwal->metode == 'online' ? 'bg-blue-200' : 'bg-green-200' }} flex items-center justify-center mr-3">
                            <svg class="w-8 h-8 {{ $jadwal->metode == 'online' ? 'text-blue-600' : 'text-green-600' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-600">{{ $jadwal->pengajuanJudul->mahasiswa->nim }}</p>
                        </div>
                    </div>
                    <!-- Status Badge -->
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Diterima
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <!-- Tanggal -->
                    <div class="flex items-center p-2 bg-white rounded-md border-l-4 border-blue-400">
                        <svg class="w-5 h-5 mr-3 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Tanggal</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d F Y') }}</p>
                        </div>
                    </div>

                    <!-- Waktu -->
                    <div class="flex items-center p-2 bg-white rounded-md border-l-4 border-purple-400">
                        <svg class="w-5 h-5 mr-3 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Waktu</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($jadwal->waktu_pengajuan)->format('H:i') }} WIB</p>
                        </div>
                    </div>

                    <!-- Metode -->
                    <div class="flex items-center p-2 bg-white rounded-md border-l-4 {{ $jadwal->metode == 'online' ? 'border-blue-400' : 'border-green-400' }}">
                        @if($jadwal->metode == 'online')
                            <svg class="w-5 h-5 mr-3 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-3 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Metode</p>
                            <p class="font-medium flex items-center">
                                @if($jadwal->metode == 'online')
                                    <span class="text-blue-600">🖥️ Online Meeting</span>
                                @else
                                    <span class="text-green-600">🏢 Offline Meeting</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Keterangan Umum -->
                    @if($jadwal->keterangan)
                    <div class="flex items-start p-2 bg-white rounded-md border-l-4 border-orange-400">
                        <svg class="w-5 h-5 mr-3 text-orange-600 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Topik Bahasan</p>
                            <p class="text-sm leading-relaxed">{{ $jadwal->keterangan }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Keterangan Khusus untuk Offline -->
                    @if($jadwal->metode == 'offline' && $jadwal->keterangan_ditampilkan_offline)
                    <div class="flex items-start p-2 bg-green-50 rounded-md border-l-4 border-green-500">
                        <svg class="w-5 h-5 mr-3 text-green-600 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-xs text-green-600 uppercase tracking-wide font-medium">Lokasi & Info Offline</p>
                            <p class="text-sm leading-relaxed text-green-800">{{ $jadwal->keterangan_ditampilkan_offline }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Action Button - Hanya untuk Online -->
                    <div class="flex items-center justify-between mt-3 pt-3 border-t border-gray-200">
                        @if($jadwal->metode == 'online')
                            <a href="{{ route('dosen.dokumen.online', $jadwal->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg transform hover:scale-105">
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Kelola Dokumen Online
                            </a>
                            {{-- <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full">
                                📹 Meeting Online
                            </span> --}}
                        @else
                            <div class="flex items-center text-green-600">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm font-medium">Siap untuk pertemuan tatap muka</span>
                            </div>
                            {{-- <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">
                                🏢 Offline
                            </span> --}}
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4">
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada jadwal hari ini</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ada jadwal bimbingan yang diterima untuk hari ini</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Jadwal Mendatang Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h2 class="text-xl font-bold">Jadwal Mendatang</h2>
            </div>

            {{-- <div class="relative">
                <input type="text" id="search" placeholder="Cari jadwal..." class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div> --}}
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left">MAHASISWA</th>
                        <th class="py-3 px-4 text-left">JUDUL</th>
                        <th class="py-3 px-4 text-left">METODE</th>
                        <th class="py-3 px-4 text-left">JADWAL</th>
                        <th class="py-3 px-4 text-left">STATUS</th>
                        <th class="py-3 px-4 text-left">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalMendatang as $jadwal)
                    <tr class="border-t hover:bg-gray-50" data-id="{{ $jadwal->id }}" data-metode="{{ $jadwal->metode }}">
                        <td class="py-3 px-4">{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap }}</td>
                        <td class="py-3 px-4">{{ $jadwal->pengajuanJudul->judul }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : ($jadwal->metode == 'offline' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $jadwal->metode == 'online' ? 'Online Meeting' : ($jadwal->metode == 'offline' ? 'Offline Meeting' : '-') }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            @if($jadwal->status == 'diproses')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                            @elseif($jadwal->status == 'diterima')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Disetujui</span>
                            @elseif($jadwal->status == 'ditolak')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Ditolak</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Selesai</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2">
                                @if($jadwal->status == 'diproses')
                                <button type="button" class="approve-btn bg-green-100 text-green-800 p-2 rounded-md" title="Setujui" data-id="{{ $jadwal->id }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <button type="button" class="reject-btn bg-red-100 text-red-800 p-2 rounded-md" title="Tolak">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                @endif
                                <button type="button"
                                        class="detail-btn bg-green-500 text-white p-2 rounded-md hover:bg-green-600 transition-colors"
                                        title="Detail"
                                        data-id="{{ $jadwal->id }}"
                                        data-mahasiswa="{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap }}"
                                        data-tanggal="{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d F Y') }}"
                                        data-waktu="{{ $jadwal->waktu_pengajuan->format('H:i') }}"
                                        data-keterangan="{{ $jadwal->keterangan ?? 'Tidak ada keterangan khusus' }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t">
                        <td colspan="6" class="py-6 text-center text-gray-500">Tidak ada jadwal bimbingan mendatang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

<!-- Fixed approve modal with improved design -->
<div id="approveModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="approve-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="approveModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel dengan animasi yang lebih smooth -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-scale-up">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-white" id="approve-modal-title">
                            Setujui Jadwal Bimbingan
                        </h3>
                    </div>
                    <button type="button" id="closeApproveModal" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <form id="approveForm" method="POST">
                    @csrf
                    <div class="space-y-6">
                        <!-- Metode Bimbingan -->
                        <div class="p-4 bg-gray-50 rounded-xl border-l-4 border-green-500">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="metode" class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Metode Bimbingan</label>
                                    <select id="metode" name="metode" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg font-medium bg-white shadow-sm transition-all duration-200" required>
                                        <option value="">-- Pilih Metode Bimbingan --</option>
                                        <option value="online">🖥️ Online Meeting</option>
                                        <option value="offline">🏢 Offline Meeting</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan untuk Offline -->
                        <div id="keteranganOfflineContainer" class="p-4 bg-gray-50 rounded-xl border-l-4 border-blue-500" style="display: none;">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="keterangan" class="block text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Lokasi & Keterangan</label>
                                    <textarea id="keterangan" name="keterangan" rows="4"
                                              class="w-full text-gray-800 px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none shadow-sm transition-all duration-200"
                                              placeholder="Contoh: Ruang Dosen, Departemen SI. Mohon bawa laptop dan draft skripsi terbaru."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" id="cancelApprove" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </button>
                <button type="submit" form="approveForm" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Setujui Jadwal
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal with improved design -->
<div id="rejectModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="reject-modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="rejectModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel dengan animasi yang lebih smooth -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-scale-up">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-white" id="reject-modal-title">
                            Tolak Jadwal Bimbingan
                        </h3>
                    </div>
                    <button type="button" id="closeRejectModal" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <form id="rejectForm" method="POST" action="">
                    @csrf
                    <div class="space-y-4">
                        <!-- Warning Message -->
                        <div class="p-4 bg-red-50 rounded-xl border-l-4 border-red-500">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-red-800 font-medium">Peringatan</h4>
                                    <p class="text-red-700 text-sm mt-1">Pastikan Anda memberikan alasan yang jelas untuk penolakan jadwal ini.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan Penolakan -->
                        <div class="p-4 bg-gray-50 rounded-xl border-l-4 border-orange-500">
                            <div class="flex items-start space-x-4">
                                <div class="flex-shrink-0">
                                    <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                                        <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <label for="keterangan_ditolak" class="block text-sm font-medium  uppercase tracking-wide mb-2">Alasan Penolakan</label>
                                    <textarea id="keterangan_ditolak" name="keterangan_ditolak" rows="5"
                                              class="w-full text-gray-800 px-4 py-3 border border-gray-600 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 resize-none shadow-sm transition-all duration-200"
                                              placeholder="Contoh: Jadwal bentrok dengan kegiatan dinas lain. Mohon ajukan jadwal alternatif pada hari yang berbeda."
                                              required></textarea>
                                    <p class="text-xs text-gray-500 mt-2">Minimal 10 karakter untuk memberikan penjelasan yang memadai.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button" id="cancelReject" class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Batal
                </button>
                <button type="submit" form="rejectForm" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                    Tolak Jadwal
                </button>
            </div>
        </div>
    </div>
</div>

    <!-- Hidden form for accept action -->
    <form id="acceptForm" method="POST" style="display: none;">
        @csrf
        <input type="text" name="keterangan" id="keterangan-input">
    </form>
</div>

<!-- Modal untuk detail jadwal (tambahkan setelah tabel) -->
<div id="detailJadwalModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="detailModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

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
                            @if($todaySchedules->isNotEmpty())
                                <p class="text-sm text-gray-600">{{ $todaySchedules->first()->pengajuanJudul->mahasiswa->nim }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Date & Time Info -->
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
                    </div>

                    <!-- Keterangan -->
                    <div class="p-4 bg-gray-50 rounded-xl border-l-4 border-orange-500">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 bg-orange-100 rounded-full flex items-center justify-center">
                                    <svg class="h-6 w-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Topik Bahasan</h4>
                                <p id="modalKeteranganJadwal" class="mt-1 text-gray-900 leading-relaxed"></p>
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
    // Elements untuk modal detail jadwal
    const detailJadwalModal = document.getElementById('detailJadwalModal');
    const closeDetailJadwalModal = document.getElementById('closeDetailJadwalModal');
    const closeDetailJadwalModalX = document.getElementById('closeDetailJadwalModalX');
    const detailModalOverlay = document.getElementById('detailModalOverlay');

    // Get all detail buttons
    const detailButtons = document.querySelectorAll('.detail-btn');

    // Event listeners for detail buttons
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            const mahasiswa = this.getAttribute('data-mahasiswa');
            const tanggal = this.getAttribute('data-tanggal');
            const waktu = this.getAttribute('data-waktu');
            const keterangan = this.getAttribute('data-keterangan');

            // Set data ke modal
            document.getElementById('modalMahasiswa').textContent = mahasiswa;
            document.getElementById('modalTanggalJadwal').textContent = tanggal;
            document.getElementById('modalWaktuJadwal').textContent = waktu + ' WIB';
            document.getElementById('modalKeteranganJadwal').textContent = keterangan;

            // Show modal
            detailJadwalModal.classList.remove('hidden');
        });
    });

    // Close modal function
    function closeDetailJadwalModalHandler() {
        detailJadwalModal.classList.add('hidden');
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

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');
    const metodeSelect = document.getElementById('metode');
    const keteranganOfflineContainer = document.getElementById('keteranganOfflineContainer');

    // Get all approve buttons
    const approveButtons = document.querySelectorAll('.approve-btn');
    const rejectButtons = document.querySelectorAll('.reject-btn');

    // Close buttons
    const closeApproveModal = document.getElementById('closeApproveModal');
    const closeRejectModal = document.getElementById('closeRejectModal');
    const cancelApprove = document.getElementById('cancelApprove');
    const cancelReject = document.getElementById('cancelReject');

    // Current jadwal ID being processed
    let currentJadwalId = null;

    // Event listeners for approve buttons
    approveButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentJadwalId = this.getAttribute('data-id');

            // Set the form action with the correct ID
            approveForm.action = `/dosen/jadwal-bimbingan/accept/${currentJadwalId}`;

            // Pre-select metode if it exists in the row data
            const row = this.closest('tr');
            if (row) {
                const metode = row.getAttribute('data-metode');
                if (metode) {
                    metodeSelect.value = metode;
                    // Show/hide keterangan container based on metode
                    keteranganOfflineContainer.style.display = metode === 'offline' ? 'block' : 'none';
                }
            }

            // Show the modal
            approveModal.classList.remove('hidden');
        });
    });

    // Event listeners for reject buttons
    rejectButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentJadwalId = this.closest('tr').getAttribute('data-id');

            // Set the form action with the correct ID
            rejectForm.action = `/dosen/jadwal-bimbingan/reject/${currentJadwalId}`;

            // Show the modal
            rejectModal.classList.remove('hidden');
        });
    });

    // Handle metode change
    metodeSelect.addEventListener('change', function() {
        keteranganOfflineContainer.style.display = this.value === 'offline' ? 'block' : 'none';
    });

    // Close modal handlers
    function closeApproveModalHandler() {
        approveModal.classList.add('hidden');
        currentJadwalId = null;
    }

    function closeRejectModalHandler() {
        rejectModal.classList.add('hidden');
        currentJadwalId = null;
    }

    // Attach close handlers
    closeApproveModal.addEventListener('click', closeApproveModalHandler);
    cancelApprove.addEventListener('click', closeApproveModalHandler);
    closeRejectModal.addEventListener('click', closeRejectModalHandler);
    cancelReject.addEventListener('click', closeRejectModalHandler);

    // Form submission (prevent if needed)
    approveForm.addEventListener('submit', function(e) {
        // You can add validation here if needed
        // If metode is required and not selected
        if (!metodeSelect.value) {
            e.preventDefault();
            alert('Silakan pilih metode bimbingan terlebih dahulu');
        }
    });

    rejectForm.addEventListener('submit', function(e) {
        // You can add validation here if needed
        const keteranganDitolak = document.getElementById('keterangan_ditolak');
        if (!keteranganDitolak.value.trim()) {
            e.preventDefault();
            alert('Silakan isi alasan penolakan terlebih dahulu');
        }
    });
});

    // document.querySelectorAll('.approve-btn').forEach(button => {
    //     button.addEventListener('click', function () {
    //         const id = this.dataset.id;
    //         const metode = this.closest('tr').dataset.metode;

    //         const form = document.getElementById('approveForm');
    //         form.action = `/dosen/jadwal-bimbingan/accept/${id}`;

    //         // Show modal
    //         document.getElementById('approveModal').classList.remove('hidden');

    //         // Optional: set default value in select if needed
    //         document.getElementById('metode').value = metode;
    //     });
    // });

    // document.getElementById('closeApproveModal').addEventListener('click', () => {
    //     document.getElementById('approveModal').classList.add('hidden');
    // });

    // document.getElementById('cancelApprove').addEventListener('click', () => {
    //     document.getElementById('approveModal').classList.add('hidden');
    // });

    // // Tampilkan keterangan jika metode offline dipilih
    // document.getElementById('metode').addEventListener('change', function () {
    //     const isOffline = this.value === 'offline';
    //     document.getElementById('keteranganOfflineContainer').style.display = isOffline ? 'block' : 'none';
    // });

    // Search functionality
    document.getElementById('search').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let table = document.querySelector('table');
        let rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            if(text.indexOf(input) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // // Reject Modal functionality
    // const rejectModal = document.getElementById('rejectModal');
    // const rejectForm = document.getElementById('rejectForm');

    // document.querySelectorAll('.reject-btn').forEach(button => {
    //     button.addEventListener('click', function() {
    //         let row = this.closest('tr');
    //         currentJadwalId = row.dataset.id;

    //         // Set the form action
    //         rejectForm.action = '{{ url("dosen/jadwal-bimbingan/reject") }}/' + currentJadwalId;

    //         // Show modal
    //         rejectModal.classList.remove('hidden');
    //     });
    // });

    // // Close modal
    // document.getElementById('closeRejectModal').addEventListener('click', function() {
    //     rejectModal.classList.add('hidden');
    // });

    // document.getElementById('cancelReject').addEventListener('click', function() {
    //     rejectModal.classList.add('hidden');
    // });

    // // Close modal when clicking outside
    // rejectModal.addEventListener('click', function(e) {
    //     if (e.target === rejectModal) {
    //         rejectModal.classList.add('hidden');
    //     }
    // });


</script>
<style>
.animate-scale-up {
    animation: scaleUp 0.3s ease-out;
}

@keyframes scaleUp {
    from {
        opacity: 0;
        transform: scale(0.95) translateY(10px);
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}

.backdrop-blur-sm {
    backdrop-filter: blur(4px);
}
</style>
@endpush
@endsection
