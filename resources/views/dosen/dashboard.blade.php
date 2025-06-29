@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container-fluid px-4 py-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 animate-fade-in">Dashboard Dosen</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Mahasiswa Bimbingan Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Total Mahasiswa Bimbingan</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalMahasiswa ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Mahasiswa yang dibimbing</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pengajuan Judul Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-green-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Pengajuan Judul</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalPengajuanJudul ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Judul yang diajukan</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
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
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $pendingSchedulesCount ?? 0 }}</p>
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

        {{-- <!-- Jadwal Bimbingan Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-purple-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-purple-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Jadwal Bimbingan</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalJadwalBimbingan ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Total jadwal bimbingan</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <!-- Additional Stats Cards Row -->
    {{-- <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8"> --}}
        <!-- Bimbingan Hari Ini Card -->
        {{-- <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-indigo-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Bimbingan Hari Ini</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $todayAcceptedSchedulesCount ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Jadwal yang diterima hari ini</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div> --}}
    {{-- </div> --}}

    <!-- Content Rows -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Judul Terbaru -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Pengajuan Judul Terbaru</h2>
                <a href="{{ url('dosen/pengajuanjudul') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">Lihat Semua</a>
            </div>
            @if($latestSubmissions->count() > 0)
                <div class="space-y-4">
                    @foreach($latestSubmissions as $submission)
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="mr-4 p-2 bg-blue-100 rounded-full">
                            <img src="{{ $submission->mahasiswa->foto ?? '/images/default-profile.png' }}" alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h6 class="text-md font-medium text-gray-800">{{ $submission->mahasiswa->nama ?? $submission->mahasiswa->nim }}</h6>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d F Y, H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $submission->judul }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    Sedang Diproses
                                </span>
                            </div>
                        </div>
                        <a href="/dosen/review-judul/{{ $submission->id }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium ml-4 flex items-center">
                            Review
                            <svg class="w-4 h-4 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-gray-500 mt-4">Tidak ada pengajuan judul yang sedang diproses</p>
                </div>
            @endif
        </div>

        <!-- Jadwal Bimbingan Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Jadwal Bimbingan Hari Ini</h2>
                <a href="{{ route('dosen.jadwal-bimbingan') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">Lihat Semua</a>
            </div>
            @if($todaySchedules->count() > 0)
                <div class="space-y-4">
                    @foreach($todaySchedules as $schedule)
                    <div class="flex items-center p-4 bg-gradient-to-r from-green-50 to-blue-50 rounded-lg hover:from-green-100 hover:to-blue-100 transition-all duration-200 border-l-4 border-green-400">
                        <div class="mr-4 p-2 bg-green-100 rounded-full">
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start mb-2">
                                <h6 class="text-md font-semibold text-gray-800">{{ $schedule->pengajuanJudul->mahasiswa->nama_lengkap ?? $schedule->pengajuanJudul->mahasiswa->nim ?? 'Mahasiswa Tidak Diketahui' }}</h6>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Diterima
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mb-2 font-medium">{{ $schedule->pengajuanJudul->judul ?? 'Judul tidak tersedia' }}</p>
                            <div class="flex flex-wrap gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ \Carbon\Carbon::parse($schedule->waktu_pengajuan)->format('H:i') }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $schedule->metode == 'online' ? 'bg-purple-100 text-purple-800' : 'bg-orange-100 text-orange-800' }}">
                                    <svg class="w-3 h-3 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        @if($schedule->metode == 'online')
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        @else
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        @endif
                                    </svg>
                                    {{ $schedule->metode == 'online' ? 'Online' : 'Offline' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-gray-600 font-medium mt-4">Tidak ada jadwal bimbingan hari ini</h3>
                    <p class="text-gray-500 text-sm mt-1">Jadwal bimbingan yang diterima akan ditampilkan di sini</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Animasi fade-in untuk judul
        const fadeElements = document.querySelectorAll('.animate-fade-in');
        fadeElements.forEach((el, index) => {
            el.style.opacity = 0;
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s ease-in-out';
                el.style.opacity = 1;
            }, index * 200);
        });

        // Animasi untuk cards
        const cards = document.querySelectorAll('.bg-white');
        cards.forEach((card, index) => {
            card.style.transform = 'translateY(20px)';
            card.style.opacity = 0;
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease-out';
                card.style.transform = 'translateY(0)';
                card.style.opacity = 1;
            }, index * 100);
        });
    });
</script>
<style>
    .animate-fade-in {
        opacity: 0;
    }

    /* Smooth gradient animations */
    .bg-gradient-to-r:hover {
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
    }

    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Enhanced card hover effects */
    .bg-white:hover {
        transform: translateY(-2px);
    }

    /* Custom scrollbar for better aesthetics */
    .space-y-4::-webkit-scrollbar {
        width: 4px;
    }

    .space-y-4::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .space-y-4::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .space-y-4::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>
@endsection
