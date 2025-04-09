@extends('layouts.app')

@section('content')
<div class="w-full bg-gray-100 py-12 px-4">
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-6xl mx-auto">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Mahasiswa</h2>

            @if(!Auth::user()->mahasiswa)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Akun Anda belum terhubung dengan data mahasiswa. Silahkan hubungi admin untuk mengonfigurasi akun Anda.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            @if(Auth::user()->mahasiswa)

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-blue-50 rounded-lg p-6 border border-blue-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800">Pengajuan Judul</h3>
                            <p class="text-sm text-blue-600 mt-1">Status judul Tugas Akhir Anda</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    @php
                        $pengajuanJudul = null;
                        if(Auth::user()->mahasiswa) {
                            $pengajuanJudul = Auth::user()->mahasiswa->pengajuanJudul ?? collect();
                            $pengajuanJudul = $pengajuanJudul->first();
                        }
                    @endphp

                    @if($pengajuanJudul)
                        <div class="mt-4">
                            <h4 class="font-medium">{{ $pengajuanJudul->judul }}</h4>
                            <div class="mt-2">
                                @if($pengajuanJudul->approved_ta == 'berjalan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Sedang Berjalan
                                    </span>
                                @elseif($pengajuanJudul->approved_ta == 'selesai')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Selesai
                                    </span>
                                @elseif($pengajuanJudul->approved_ta == 'dibatalkan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Dibatalkan
                                    </span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mt-4">
                            <p class="text-sm text-gray-600">Anda belum mengajukan judul Tugas Akhir.</p>
                            <a href="{{ route('mahasiswa.pengajuan-judul.create') }}" class="mt-2 inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                Ajukan Judul
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>

                <div class="bg-green-50 rounded-lg p-6 border border-green-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-green-800">Jadwal Bimbingan</h3>
                            <p class="text-sm text-green-600 mt-1">Jadwal bimbingan Anda</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>

                    @php
                        $jadwalBimbingan = 0;
                        if(Auth::user()->mahasiswa && $pengajuanJudul) {
                            $jadwalBimbingan = App\Models\JadwalBimbingan::where('pengajuan_judul_id', $pengajuanJudul->id)
                                ->where('status', 'diterima')
                                ->where('tanggal_pengajuan', '>=', now()->format('Y-m-d'))
                                ->count();
                        }
                    @endphp

                    <div class="mt-4">
                        <div class="text-3xl font-bold text-green-700">{{ $jadwalBimbingan }}</div>
                        <p class="text-sm text-gray-600 mt-1">Jadwal bimbingan aktif</p>
                        <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="mt-4 inline-flex items-center text-sm text-green-600 hover:text-green-800">
                            Lihat Semua Jadwal
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="bg-purple-50 rounded-lg p-6 border border-purple-100 shadow-sm hover:shadow-md transition-shadow duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-purple-800">Dokumen Bimbingan</h3>
                            <p class="text-sm text-purple-600 mt-1">Progress dokumen Tugas Akhir</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>

                    @php
                        $dokumenCount = 0;
                        $dokumenReviewedCount = 0;

                        if(Auth::user()->mahasiswa && $pengajuanJudul) {
                            $jadwalBimbingans = App\Models\JadwalBimbingan::where('pengajuan_judul_id', $pengajuanJudul->id)->pluck('id');

                            if(Schema::hasTable('dokumen_online')) {
                                $dokumenCount = App\Models\DokumenOnline::whereIn('jadwal_bimbingan_id', $jadwalBimbingans)->count();
                                $dokumenReviewedCount = App\Models\DokumenOnline::whereIn('jadwal_bimbingan_id', $jadwalBimbingans)
                                    ->where('status', 'selesai')
                                    ->count();
                            }
                        }
                    @endphp

                    <div class="mt-4">
                        <div class="flex items-center">
                            <div class="text-3xl font-bold text-purple-700">{{ $dokumenReviewedCount }}</div>
                            <div class="text-gray-500 ml-2">/ {{ $dokumenCount }}</div>
                        </div>
                        <p class="text-sm text-gray-600 mt-1">Dokumen telah direview</p>

                        @if($pengajuanJudul && $pengajuanJudul->approved_ta == 'berjalan')
                            <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="mt-4 inline-flex items-center text-sm text-purple-600 hover:text-purple-800">
                                Upload Dokumen Baru
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-10">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Jadwal Bimbingan Mendatang</h3>

                @php
                    $jadwalMendatang = collect();

                    if(Auth::user()->mahasiswa && $pengajuanJudul) {
                        $jadwalMendatang = App\Models\JadwalBimbingan::where('pengajuan_judul_id', $pengajuanJudul->id)
                            ->where('status', 'diterima')
                            ->where('tanggal_pengajuan', '>=', now()->format('Y-m-d'))
                            ->orderBy('tanggal_pengajuan')
                            ->orderBy('waktu_pengajuan')
                            ->with('dosen')
                            ->take(3)
                            ->get();
                    }
                @endphp

                @if(count($jadwalMendatang) > 0)
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal & Waktu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($jadwalMendatang as $jadwal)
                                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if(isset($jadwal->dosen->gambar) && $jadwal->dosen->gambar)
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . $jadwal->dosen->gambar) }}" alt="{{ $jadwal->dosen->nama_lengkap }}">
                                                        </div>
                                                    @else
                                                        <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">{{ $jadwal->dosen->nama_lengkap }}</div>
                                                        <div class="text-xs text-gray-500">{{ $jadwal->dosen->nip ?? 'NIP: -' }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900 font-medium">{{ $jadwal->tanggal_pengajuan->format('d F Y') }}</div>
                                                <div class="text-sm text-gray-500">{{ $jadwal->waktu_pengajuan->format('H:i') }} WIB</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @if(isset($jadwal->metode))
                                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                        {{ $jadwal->metode == 'online' ? 'Online Meeting' : 'Offline Meeting' }}
                                                    </span>
                                                @else
                                                    @if(strpos($jadwal->keterangan, 'Online') !== false || strpos($jadwal->keterangan, 'online') !== false)
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                            Online Meeting
                                                        </span>
                                                    @else
                                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                            Offline Meeting
                                                        </span>
                                                    @endif
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('mahasiswa.jadwal-bimbingan.show', $jadwal->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1 rounded-full transition-colors duration-200">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                            <div class="flex justify-end">
                                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Lihat Semua Jadwal
                                </a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md shadow-sm">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Belum ada jadwal bimbingan mendatang. Silahkan ajukan jadwal bimbingan baru.
                                </p>
                                <div class="mt-4">
                                    <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                        Ajukan Jadwal Bimbingan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
