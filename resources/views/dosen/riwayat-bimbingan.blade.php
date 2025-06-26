@extends('layouts.dosen')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Riwayat Bimbingan</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Total Riwayat Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Riwayat</p>
                    <h3 class="text-4xl font-bold">{{ $totalRiwayat }}</h3>
                </div>
            </div>
        </div>

        <!-- Bulan Ini Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Bulan Ini</p>
                    <h3 class="text-4xl font-bold">{{ $riwayatBulanIni }}</h3>
                </div>
            </div>
        </div>

        <!-- Bimbingan Online Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Bimbingan Online</p>
                    <h3 class="text-4xl font-bold">{{ $riwayatOnline }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dan Search Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <form method="GET" action="{{ route('dosen.riwayat-bimbingan') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Search Input -->
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari mahasiswa atau judul..." class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 w-full">
                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <!-- Start Date -->
            <div>
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Tanggal Mulai">
            </div>

            <!-- End Date -->
            {{-- <div>
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Tanggal Akhir">
            </div> --}}

            <!-- Metode Filter -->
            <div>
                <select name="metode" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                    <option value="">Semua Metode</option>
                    <option value="online" {{ request('metode') == 'online' ? 'selected' : '' }}>Online</option>
                    <option value="offline" {{ request('metode') == 'offline' ? 'selected' : '' }}>Offline</option>
                </select>
            </div>

            <!-- Filter Button -->
            <div class="flex space-x-2">
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.707V4z" />
                    </svg>
                    Filter
                </button>
                <a href="{{ route('dosen.riwayat-bimbingan') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">Reset</a>
            </div>
        </form>
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

            {{-- <div class="flex space-x-2">
                <a href="#" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 flex items-center">
                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export PDF
                </a>
            </div> --}}
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
                                <div class="font-semibold">{{ $jadwal->pengajuanJudul->mahasiswa->nama ?? $jadwal->pengajuanJudul->mahasiswa->nama_lengkap }}</div>
                                <div class="text-sm text-gray-600">{{ $jadwal->pengajuanJudul->mahasiswa->nim }}</div>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="max-w-xs truncate" title="{{ $jadwal->pengajuanJudul->judul }}">
                                {{ Str::limit($jadwal->pengajuanJudul->judul, 50) }}
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
                            <div class="max-w-xs truncate" title="{{ $jadwal->keterangan }}">
                                {{ $jadwal->keterangan ? Str::limit($jadwal->keterangan, 30) : 'Tidak ada keterangan' }}
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2">
                                <a href="#" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors" title="Detail">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
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
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto submit form when date inputs change
    const startDate = document.querySelector('input[name="start_date"]');
    const endDate = document.querySelector('input[name="end_date"]');
    const metodeSelect = document.querySelector('select[name="metode"]');

    // Optional: Auto-submit when date or metode changes
    // Uncomment if you want instant filtering
    /*
    [startDate, endDate, metodeSelect].forEach(element => {
        if (element) {
            element.addEventListener('change', function() {
                this.closest('form').submit();
            });
        }
    });
    */
});
</script>
@endpush
@endsection
