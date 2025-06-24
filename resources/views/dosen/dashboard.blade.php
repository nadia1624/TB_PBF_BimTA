@extends('layouts.dosen')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container-fluid px-4 py-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 animate-fade-in">Dashboard Dosen</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 transform hover:-translate-y-2">
            <div class="flex items-center">
                <div class="mr-4 p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-users text-blue-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 uppercase tracking-wide">Total Mahasiswa Bimbingan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalMahasiswa ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 transform hover:-translate-y-2">
            <div class="flex items-center">
                <div class="mr-4 p-3 bg-green-100 rounded-full">
                    <i class="fas fa-file-alt text-green-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 uppercase tracking-wide">Pengajuan Judul</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalPengajuanJudul ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-gray-100 transform hover:-translate-y-2">
            <div class="flex items-center">
                <div class="mr-4 p-3 bg-purple-100 rounded-full">
                    <i class="fas fa-calendar-alt text-purple-600 text-2xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 uppercase tracking-wide">Jadwal Bimbingan</p>
                    <p class="text-3xl font-extrabold text-gray-900 mt-1">{{ $totalJadwalBimbingan ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Rows -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Judul Terbaru -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Pengajuan Judul Terbaru</h2>
                <a href="{{ route('dosen.jadwal-bimbingan') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">Lihat Semua</a>
            </div>
            @if(isset($latestSubmissions) && $latestSubmissions->count() > 0)
                <div class="space-y-4">
                    @foreach($latestSubmissions as $submission)
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="mr-4 p-2 bg-blue-100 rounded-full">
                            <i class="fas fa-file-alt text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center">
                                <h6 class="text-md font-medium text-gray-800">{{ $submission->mahasiswa->nama }} - {{ $submission->mahasiswa->nim }}</h6>
                                <span class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($submission->created_at)->format('d F Y, H:i') }}</span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">{{ $submission->judul }}</p>
                        </div>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium ml-4">Review <i class="fas fa-chevron-right"></i></a>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 mt-4">Tidak ada pengajuan judul terbaru</p>
                </div>
            @endif
        </div>

        <!-- Jadwal Bimbingan Hari Ini -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Jadwal Bimbingan Hari Ini</h2>
                @if(isset($todaySchedules) && $todaySchedules->count() > 0)
                    <a href="{{ route('dosen.jadwal-bimbingan') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors duration-200">Lihat Semua</a>
                @endif
            </div>
            @if(isset($todaySchedules) && $todaySchedules->count() > 0)
                <div class="space-y-4">
                    @foreach($todaySchedules as $schedule)
                    <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <div class="mr-4 p-2 bg-purple-100 rounded-full">
                            <i class="fas fa-calendar-check text-purple-600"></i>
                        </div>
                        <div class="flex-1">
                            <h6 class="text-md font-medium text-gray-800">{{ $schedule->pengajuanJudul->mahasiswa->nama }}</h6>
                            <p class="text-sm text-gray-600 mt-1">{{ $schedule->pengajuanJudul->judul }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                    {{ \Carbon\Carbon::parse($schedule->waktu_pengajuan)->format('H:i') }}
                                </span>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $schedule->metode == 'online' ? 'bg-info-100 text-info-800' : 'bg-green-100 text-green-800' }}">
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
                        <i class="fas fa-calendar-check text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-500 mt-4">Tidak ada jadwal bimbingan hari ini</p>
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
    });
</script>
<style>
    .icon-square {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .bg-info-100 { background-color: #e0f2fe; }
    .text-info-800 { color: #1e40af; }
    .animate-fade-in {
        opacity: 0;
    }
</style>
@endsection
