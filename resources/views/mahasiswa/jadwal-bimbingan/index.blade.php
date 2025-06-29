@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <!-- Form Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8 transition-all duration-300 hover:shadow-xl">
    <div class="border-b border-gray-100">
        <div class="px-8 py-5">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Pengajuan Jadwal Bimbingan
            </h2>
        </div>
    </div>

    <div class="px-8 py-4 pb-8">
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        {{-- Cek apakah pengajuan judul ada dan statusnya --}}
        @if(!isset($pengajuanJudul))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-yellow-800">Belum Ada Pengajuan Judul</p>
                        <p class="text-sm text-yellow-700 mt-1">Anda perlu mengajukan judul terlebih dahulu sebelum dapat mengajukan jadwal bimbingan.</p>
                    </div>
                </div>
            </div>
        @elseif($pengajuanJudul->approved_ta === 'disetujui')
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">Pengajuan Judul Disetujui</p>
                        <p class="text-sm text-green-700 mt-1">
                            Pengajuan judul Anda telah <span class="font-semibold">disetujui</span>.
                            Pengajuan jadwal bimbingan tidak dapat dilakukan lagi.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($pengajuanJudul->approved_ta === 'ditolak')
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-red-800">Pengajuan Judul Ditolak</p>
                        <p class="text-sm text-red-700 mt-1">
                            Pengajuan judul Anda telah <span class="font-semibold">ditolak</span>.
                            Silakan ajukan judul baru atau hubungi koordinator TA.
                        </p>
                    </div>
                </div>
            </div>
        @else
            {{-- Form pengajuan jadwal bimbingan --}}
            <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.store') }}">
                @csrf

                @if(isset($pengajuanJudul))
                    <input type="hidden" name="pengajuan_judul_id" value="{{ $pengajuanJudul->id }}">
                @endif

                <div class="space-y-4 mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="dosen_id">
                        Pilih Dosen Pembimbing
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(isset($dosenPembimbing) && count($dosenPembimbing) > 0)
                            @php
                                $pembimbing1Dosen = null;
                                $pembimbing2Dosen = null;

                                // Cari dosen pembimbing 1 dan 2
                                foreach($dosenPembimbing as $dosen) {
                                    $detailDosen = App\Models\DetailDosen::where('dosen_id', $dosen->id)
                                        ->where('pengajuan_judul_id', $pengajuanJudul->id)
                                        ->first();

                                    if($detailDosen) {
                                        if($detailDosen->pembimbing == 'pembimbing 1') {
                                            $pembimbing1Dosen = $dosen;
                                        } elseif($detailDosen->pembimbing == 'pembimbing 2') {
                                            $pembimbing2Dosen = $dosen;
                                        }
                                    }
                                }
                            @endphp

                            <!-- Dosen Pembimbing 1 -->
                            @if($pembimbing1Dosen)
                            <div class="border rounded-xl p-4 transition-all duration-200 hover:shadow-md cursor-pointer {{ old('dosen_id', $pembimbing1Dosen->id) == $pembimbing1Dosen->id ? 'border-green-500 bg-green-50' : 'border-gray-200' }}"
                                 onclick="document.getElementById('dosen_id_1').checked = true; updateDosenSelection();">
                                <label class="flex items-start cursor-pointer">
                                    <input type="radio" name="dosen_id" id="dosen_id_1" value="{{ $pembimbing1Dosen->id }}"
                                        class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500"
                                        {{ old('dosen_id', $pembimbing1Dosen->id) == $pembimbing1Dosen->id ? 'checked' : '' }}
                                        onchange="updateDosenSelection()">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $pembimbing1Dosen->nama_lengkap }}
                                        </div>
                                        <div class="text-gray-600">Dosen Pembimbing 1</div>
                                    </div>
                                </label>
                            </div>
                            @endif

                            <!-- Dosen Pembimbing 2 -->
                            @if($pembimbing2Dosen)
                            <div class="border rounded-xl p-4 transition-all duration-200 hover:shadow-md cursor-pointer {{ old('dosen_id') == $pembimbing2Dosen->id ? 'border-green-500 bg-green-50' : 'border-gray-200' }}"
                                 onclick="document.getElementById('dosen_id_2').checked = true; updateDosenSelection();">
                                <label class="flex items-start cursor-pointer">
                                    <input type="radio" name="dosen_id" id="dosen_id_2" value="{{ $pembimbing2Dosen->id }}"
                                        class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500"
                                        {{ old('dosen_id') == $pembimbing2Dosen->id ? 'checked' : '' }}
                                        onchange="updateDosenSelection()">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ $pembimbing2Dosen->nama_lengkap }}
                                        </div>
                                        <div class="text-gray-600">Dosen Pembimbing 2</div>
                                    </div>
                                </label>
                            </div>
                            @endif
                        @else
                            <div class="col-span-2 text-yellow-700 bg-yellow-50 p-4 rounded-lg border-l-4 border-yellow-400">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm">Anda belum memiliki dosen pembimbing. Silahkan ajukan judul terlebih dahulu.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    @error('dosen_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="block text-gray-700 font-medium mb-2" for="tanggal_pengajuan">
                            Tanggal Bimbingan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200"
                                value="{{ old('tanggal_pengajuan') }}" min="{{ date('Y-m-d') }}">
                        </div>
                        @error('tanggal_pengajuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4 mb-4">
                        <label class="block text-gray-700 font-medium mb-2" for="waktu_pengajuan">
                            Waktu Bimbingan
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="time" name="waktu_pengajuan" id="waktu_pengajuan"
                                class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200"
                                value="{{ old('waktu_pengajuan') }}">
                        </div>
                        @error('waktu_pengajuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-4 mb-4">
                    <label class="block text-gray-700 font-medium mb-2" for="keterangan">
                        Keterangan / Topik Bahasan
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="4"
                        class="block w-full rounded-md border-gray-300 text-gray-600 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200"
                        placeholder="Tuliskan topik apa yang akan dibahas dalam bimbingan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-4">
                    <button type="reset" id="resetBtn" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-sm transition-all duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Form
                    </button>
                    <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-sm transition-all duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Ajukan Jadwal
                    </button>
                </div>
            </form>
        @endif
    </div>
</div>

        <!-- History Section -->
<div class="bg-white rounded-xl shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
    <div class="border-b border-gray-100">
        <div class="px-8 py-5">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Riwayat Pengajuan Bimbingan
            </h2>
        </div>
    </div>

    <div class="p-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if(isset($jadwalBimbingan) && count($jadwalBimbingan) > 0)
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosen</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Jam</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($jadwalBimbingan as $jadwal)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if(isset($jadwal->dosen->gambar) && $jadwal->dosen->gambar)
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $jadwal->dosen->gambar) }}" alt="{{ $jadwal->dosen->nama_lengkap }}">
                                            </div>
                                        @else
                                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $jadwal->dosen->nama_lengkap }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $jadwal->tanggal_pengajuan->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="text-sm text-gray-900">{{ $jadwal->waktu_pengajuan->format('H:i') }} WIB</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if(isset($jadwal->metode) && !empty($jadwal->metode))
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                            {{ $jadwal->metode == 'online' ? 'Online Meeting' : 'Offline Meeting' }}
                                        </span>
                                    @else
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-600">
                                            -
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($jadwal->status == 'diproses')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Diproses
                                        </span>
                                    @elseif($jadwal->status == 'diterima')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Disetujui
                                        </span>
                                    @elseif($jadwal->status == 'ditolak')
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                    <div class="flex justify-center">
                                        @if($jadwal->status == 'ditolak')
                                            <!-- Tombol untuk menampilkan modal alasan penolakan -->
                                            <button type="button"
                                                    onclick="showRejectionReason({{ $jadwal->id }}, '{{ $jadwal->keterangan_ditolak }}')"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Alasan
                                            </button>
                                        @elseif($jadwal->status == 'diterima')
                                            <!-- Tombol untuk melihat detail bimbingan -->
                                            <a href="{{ route('mahasiswa.jadwal-bimbingan.show', $jadwal->id) }}"
                                               class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                                Bimbingan
                                            </a>
                                        @else
                                            <!-- Tombol untuk melihat detail jadwal yang diproses -->
                                            <button type="button" onclick="showDetailModal('{{ $jadwal->dosen->nama_lengkap }}', '{{ $jadwal->tanggal_pengajuan->format('d M Y') }}', '{{ $jadwal->waktu_pengajuan->format('H:i') }}', '{{ $jadwal->keterangan }}')"
                                                    class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </button>

                                            <!-- Tombol untuk membatalkan jadwal yang masih diproses -->
                                            <button type="button"
                                                    class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 cancel-btn"
                                                    data-jadwal-id="{{ $jadwal->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Batal
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Belum ada jadwal bimbingan yang diajukan. Silahkan ajukan jadwal bimbingan baru.
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Modal Pembatalan Jadwal -->
<div id="cancelModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="cancelModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel dengan animasi yang lebih smooth -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-scale-up">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-white" id="modal-title">
                            Konfirmasi Pembatalan
                        </h3>
                    </div>
                    <button type="button" id="closeCancelModalX" class="text-white hover:text-gray-200 transition-colors duration-200">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <!-- Peringatan utama -->
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-lg font-semibold text-red-800">Batalkan Jadwal Bimbingan?</h4>
                            <p class="text-sm text-red-600 mt-1">Anda akan membatalkan jadwal bimbingan yang telah diajukan</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi peringatan -->
                <div class="p-4 bg-gray-50 rounded-xl border-l-4 border-red-500">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Peringatan</h4>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p class="text-gray-900 leading-relaxed">
                                    Tindakan ini tidak dapat dibatalkan. Jika Anda membatalkan jadwal ini, Anda perlu mengajukan jadwal bimbingan baru jika masih diperlukan.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form pembatalan -->
                <form id="cancelForm" method="POST" class="mt-6">
                    @csrf
                    @method('DELETE')
                    <!-- Form content akan ditambahkan di sini jika diperlukan -->
                </form>

                <!-- Informasi tambahan -->
                {{-- <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800 mb-1">Informasi</h4>
                            <p class="text-sm text-blue-700">Pastikan Anda benar-benar ingin membatalkan jadwal bimbingan ini sebelum melanjutkan.</p>
                        </div>
                    </div>
                </div> --}}
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end space-x-3">
                <button type="button"
                        id="cancelCancelModal"
                        class="inline-flex items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200 shadow-sm hover:shadow-md">
                    {{-- <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg> --}}
                    Tidak
                </button>
                <button type="submit"
                        form="cancelForm"
                        class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg> --}}
                    Ya, Batalkan
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk detail bimbingan -->
<div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

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
                    <button type="button" id="closeDetailModalX" class="text-white hover:text-gray-200 transition-colors duration-200">
                        {{-- <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg> --}}
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <div class="space-y-4">
                    <!-- Dosen Info -->
                    <div class="flex items-start space-x-4 p-4 bg-gray-50 rounded-xl border-l-4 border-blue-500">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide">Dosen Pembimbing</h4>
                            <p id="modalDosen" class="mt-1 text-lg font-semibold text-gray-900"></p>
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
                                <p id="modalTanggal" class="mt-1 text-lg font-semibold text-gray-900"></p>
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
                                <p id="modalWaktu" class="mt-1 text-lg font-semibold text-gray-900"></p>
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
                                <p id="modalKeterangan" class="mt-1 text-gray-900 leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-end">
                <button type="button" id="closeDetailModal" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk alasan penolakan -->
<div id="rejectionModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay dengan blur effect -->
        <div id="rejectionModalOverlay" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-all duration-300" aria-hidden="true"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel dengan animasi -->
        <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all duration-300 sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full animate-scale-up">
            <!-- Header Modal -->
            <div class="bg-gradient-to-r from-red-600 to-red-700 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 h-10 w-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-bold text-white">
                            Jadwal Bimbingan Ditolak
                        </h3>
                    </div>
                    <button type="button" id="closeRejectionModalX" class="text-white hover:text-gray-200 transition-colors duration-200">
                        {{-- <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg> --}}
                    </button>
                </div>
            </div>

            <!-- Content Modal -->
            <div class="bg-white px-6 py-6">
                <!-- Status Alert -->
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-lg font-semibold text-red-800">Pengajuan Jadwal Ditolak</h4>
                            <p class="text-sm text-red-600 mt-1">Dosen pembimbing telah menolak jadwal bimbingan yang Anda ajukan</p>
                        </div>
                    </div>
                </div>

                <!-- Alasan Penolakan -->
                <div class="p-4 bg-gray-50 rounded-xl border-l-4 border-red-500">
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            <div class="h-12 w-12 bg-red-100 rounded-full flex items-center justify-center">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wide mb-2">Alasan Penolakan</h4>
                            <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                <p id="rejectionReason" class="text-gray-900 leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Saran tindak lanjut -->
                <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-800 mb-1">Tindak Lanjut</h4>
                            <p class="text-sm text-blue-700">Silahkan ajukan jadwal bimbingan baru dengan memperhatikan alasan penolakan di atas.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="bg-gray-50 px-6 py-4 flex justify-between">
                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}"
                id="newScheduleBtn"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Ajukan Jadwal Baru
                </a>
                <button type="button" id="closeModal" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showDetailModal(dosen, tanggal, waktu, keterangan) {
        document.getElementById('modalDosen').textContent = dosen;
        document.getElementById('modalTanggal').textContent = tanggal;
        document.getElementById('modalWaktu').textContent = waktu + ' WIB';
        document.getElementById('modalKeterangan').textContent = keterangan;
        document.getElementById('detailModal').classList.remove('hidden');
    }
    document.getElementById('closeDetailModal').addEventListener('click', function() {
        document.getElementById('detailModal').classList.add('hidden');
    });
    document.getElementById('modalOverlay').addEventListener('click', function() {
        document.getElementById('detailModal').classList.add('hidden');
    });

    // Fungsi untuk menampilkan modal alasan penolakan
    function showRejectionReason(jadwalId, reason) {
        const modal = document.getElementById('rejectionModal');
        const reasonElement = document.getElementById('rejectionReason');

        // Set alasan penolakan
        reasonElement.textContent = reason || 'Tidak ada alasan penolakan yang diberikan oleh dosen.';

        // Tampilkan modal
        modal.classList.remove('hidden');
    }

    function updateDosenSelection() {
        // Reset semua card ke tampilan normal
        const cards = document.querySelectorAll('[name="dosen_id"]');
        cards.forEach(card => {
            const cardContainer = card.closest('div.border');
            if (card.checked) {
                cardContainer.classList.add('border-green-500', 'bg-green-50');
                cardContainer.classList.remove('border-gray-200');
            } else {
                cardContainer.classList.remove('border-green-500', 'bg-green-50');
                cardContainer.classList.add('border-gray-200');
            }
        });
    }

    function updateMetodeSelection() {
        // Reset semua card ke tampilan normal
        const cards = document.querySelectorAll('[name="metode"]');
        cards.forEach(card => {
            const cardContainer = card.closest('div.border');
            if (card.checked) {
                cardContainer.classList.add('border-green-500', 'bg-green-50');
                cardContainer.classList.remove('border-gray-200');
            } else {
                cardContainer.classList.remove('border-green-500', 'bg-green-50');
                cardContainer.classList.add('border-gray-200');
            }
        });
    }

    // Menutup modal saat overlay di-klik
    document.getElementById('modalOverlay').addEventListener('click', function() {
        document.getElementById('rejectionModal').classList.add('hidden');
    });

    // Menutup modal saat tombol tutup di-klik
    document.getElementById('closeModal').addEventListener('click', function() {
        document.getElementById('rejectionModal').classList.add('hidden');
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modal = document.getElementById('rejectionModal');
            if (!modal.classList.contains('hidden')) {
                modal.classList.add('hidden');
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Set Dosen Pembimbing 1 sebagai default jika tidak ada selection dari old input
        const pembimbing1Radio = document.getElementById('dosen_id_1');
        if (pembimbing1Radio && !document.querySelector('[name="dosen_id"]:checked')) {
            pembimbing1Radio.checked = true;
        }

        updateDosenSelection();
        updateMetodeSelection();

        // Handle reset button
        document.getElementById('resetBtn').addEventListener('click', function(e) {
            // Tunggu sampai form benar-benar direset
            setTimeout(function() {
                // Set Dosen Pembimbing 1 sebagai default
                const pembimbing1Radio = document.getElementById('dosen_id_1');
                if (pembimbing1Radio) {
                    pembimbing1Radio.checked = true;
                }

                // Update tampilan
                updateDosenSelection();
                updateMetodeSelection();
            }, 10); // Delay sedikit untuk memastikan browser selesai mereset form
        });
    });

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const cancelModal = document.getElementById('cancelModal');
    const cancelForm = document.getElementById('cancelForm');
    const closeCancelModalX = document.getElementById('closeCancelModalX');
    const cancelCancelModal = document.getElementById('cancelCancelModal');
    const cancelModalOverlay = document.getElementById('cancelModalOverlay');

    // Get all cancel buttons
    const cancelButtons = document.querySelectorAll('.cancel-btn');

    // Current jadwal ID being processed
    let currentJadwalId = null;

    // Event listeners for cancel buttons
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentJadwalId = this.getAttribute('data-jadwal-id');

            // Set form action with correct route
            cancelForm.action = `/mahasiswa/jadwal-bimbingan/${currentJadwalId}`;

            // Show modal
            cancelModal.classList.remove('hidden');
        });
    });

    // Close modal function
    function closeCancelModalHandler() {
        cancelModal.classList.add('hidden');
        currentJadwalId = null;
        cancelForm.reset();
    }

    // Close modal event listeners
    closeCancelModalX.addEventListener('click', closeCancelModalHandler);
    cancelCancelModal.addEventListener('click', closeCancelModalHandler);
    cancelModalOverlay.addEventListener('click', closeCancelModalHandler);

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !cancelModal.classList.contains('hidden')) {
            closeCancelModalHandler();
        }
    });
});
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
@endsection
