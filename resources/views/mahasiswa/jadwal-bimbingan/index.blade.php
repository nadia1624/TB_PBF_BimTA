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
                                                Dosen Pembimbing 1
                                            </div>
                                            <div class="text-gray-600">{{ $pembimbing1Dosen->nama_lengkap }}</div>
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
                                                Dosen Pembimbing 2
                                            </div>
                                            <div class="text-gray-600">{{ $pembimbing2Dosen->nama_lengkap }}</div>
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
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50 transition-all duration-200"
                            placeholder="Tuliskan topik apa yang akan dibahas dalam bimbingan">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- <div class="space-y-4 mb-6">
                        <label class="block text-gray-700 font-medium mb-2" for="metode">
                            Metode Bimbingan
                        </label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="border rounded-xl p-4 transition-all duration-200 hover:shadow-md cursor-pointer {{ old('metode', 'online') == 'online' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}"
                                 onclick="document.getElementById('metode_online').checked = true; updateMetodeSelection();">
                                <label class="flex items-start cursor-pointer">
                                    <input type="radio" name="metode" id="metode_online" value="online"
                                        class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500"
                                        {{ old('metode', 'online') == 'online' ? 'checked' : '' }}
                                        onchange="updateMetodeSelection()">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                            </svg>
                                            Online Meeting
                                        </div>
                                        <div class="text-gray-600 text-sm mt-1">Pertemuan dilakukan secara virtual dengan mengupload dokumen Tugas Akhir</div>
                                    </div>
                                </label>
                            </div>

                            <div class="border rounded-xl p-4 transition-all duration-200 hover:shadow-md cursor-pointer {{ old('metode') == 'offline' ? 'border-green-500 bg-green-50' : 'border-gray-200' }}"
                                 onclick="document.getElementById('metode_offline').checked = true; updateMetodeSelection();">
                                <label class="flex items-start cursor-pointer">
                                    <input type="radio" name="metode" id="metode_offline" value="offline"
                                        class="mt-1 h-4 w-4 text-green-600 focus:ring-green-500"
                                        {{ old('metode') == 'offline' ? 'checked' : '' }}
                                        onchange="updateMetodeSelection()">
                                    <div class="ml-3">
                                        <div class="font-semibold text-gray-800 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Offline Meeting
                                        </div>
                                        <div class="text-gray-600 text-sm mt-1">Pertemuan dilakukan secara tatap muka di kampus</div>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @error('metode')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div> --}}

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
                Riwayat Bimbingan
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
                                    @elseif(isset($jadwal->keterangan) && !empty($jadwal->keterangan))
                                        @if(strpos($jadwal->keterangan, 'Online') !== false || strpos($jadwal->keterangan, 'online') !== false)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Online Meeting
                                            </span>
                                        @elseif(strpos($jadwal->keterangan, 'Offline') !== false || strpos($jadwal->keterangan, 'offline') !== false)
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Offline Meeting
                                            </span>
                                        @endif
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
                                            <a href="{{ route('mahasiswa.jadwal-bimbingan.show', $jadwal->id) }}"
                                               class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                Detail
                                            </a>

                                            <!-- Tombol untuk membatalkan jadwal yang masih diproses -->
                                            <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.destroy', $jadwal->id) }}" class="inline ml-2">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                                        onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal bimbingan ini?')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Batal
                                                </button>
                                            </form>
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

<!-- Modal untuk alasan penolakan -->
<div id="rejectionModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="modalOverlay" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <!-- Trick untuk membuat modal vertikal center -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Alasan Penolakan Jadwal Bimbingan
                        </h3>
                        <div class="mt-4">
                            <div class="text-sm text-gray-500">
                                <p id="rejectionReason" class="text-base text-gray-700"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" id="closeModal" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
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

                // Set Online sebagai default untuk metode
                const metodeOnlineRadio = document.getElementById('metode_online');
                if (metodeOnlineRadio) {
                    metodeOnlineRadio.checked = true;
                }

                // Update tampilan
                updateDosenSelection();
                updateMetodeSelection();
            }, 10); // Delay sedikit untuk memastikan browser selesai mereset form
        });
    });

</script>
@endsection
