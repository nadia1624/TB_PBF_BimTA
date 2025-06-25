@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-black mb-2">Dashboard</h2>
    <p class="text-gray-600 dark:text-gray-400 mb-8">Selamat datang di panel admin.</p>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Mahasiswa Bimbingan -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Mahasiswa</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalMahasiswa }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pengajuan Judul -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pengajuan Judul</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalPengajuanJudul }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Jadwal Bimbingan -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Jadwal Bimbingan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $totalJadwalBimbingan }}</p>
                </div>
                <div class="bg-gray-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Judul Terbaru -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Pengajuan Judul Terbaru</h3>
            <div class="space-y-4">
                @forelse ($pengajuanJudulTerbaru as $pengajuan)
                    <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="bg-gray-200 p-2 rounded">
                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $pengajuan->mahasiswa->nama_lengkap }} - {{ $pengajuan->mahasiswa->nim }}</h4>
                            <p class="text-sm text-gray-600">{{ $pengajuan->judul }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ $pengajuan->created_at->format('d F Y | H:i') }}</p>
                        </div>
                        {{-- <a href="{{ route('admin.pengajuan-judul.review', $pengajuan->id) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Review →
                        </a> --}}
                    </div>
                @empty
                    <div class="text-center text-gray-600 py-4">Tidak ada pengajuan judul terbaru.</div>
                @endforelse
            </div>
        </div>

        <!-- Jadwal Bimbingan Hari Ini -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Jadwal Bimbingan Hari Ini</h3>
    @if ($jadwalBimbinganHariIni > 0)
        <div class="space-y-4">
            @forelse ($jadwalBimbinganHariIniDetails as $jadwal)
                <div class="flex items-start space-x-3 p-3 bg-gray-50 rounded-lg">
                    <div class="bg-gray-200 p-2 rounded">
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-900">{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap ?? 'Nama Tidak Ditemukan' }}</h4>
                        <p class="text-sm text-gray-600">{{ $jadwal->waktu_pengajuan }} WIB</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $jadwal->keterangan ?? 'Lokasi Tidak Ditemukan' }}</p>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-600 py-4">Tidak ada detail jadwal untuk hari ini.</div>
            @endforelse
        </div>
    @else
        <div class="flex flex-col items-center justify-center h-64 text-center">
            <div class="bg-gray-100 p-4 rounded-full mb-4">
                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-gray-600 font-medium">Tidak ada jadwal bimbingan hari ini</p>
            {{-- <a href="{{ route('admin.jadwal-bimbingan.index') }}" class="mt-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                Lihat Semua Jadwal →
            </a> --}}
        </div>
    @endif
</div>
    </div>
</div>
@endsection
