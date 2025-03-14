@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Form Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-6xl mx-auto mb-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Pengajuan Jadwal Bimbingan</h2>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.store') }}">
                @csrf

                @if(isset($pengajuanJudul))
                    <input type="hidden" name="pengajuan_judul_id" value="{{ $pengajuanJudul->id }}">
                @endif

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="dosen_id">
                        Pilih Dosen Pembimbing
                    </label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if(isset($dosenPembimbing) && count($dosenPembimbing) > 0)
                            @foreach($dosenPembimbing as $index => $dosen)
                                <div class="border rounded-lg p-4 {{ old('dosen_id') == $dosen->id ? 'border-green-500 bg-green-50' : 'border-gray-300' }}">
                                    <label class="flex items-start">
                                        <input type="radio" name="dosen_id" value="{{ $dosen->id }}" class="mt-1" {{ old('dosen_id') == $dosen->id ? 'checked' : '' }} {{ $index === 0 && !old('dosen_id') ? 'checked' : '' }}>
                                        <div class="ml-3">
                                            <div class="font-semibold text-gray-800">Dosen Pembimbing {{ $index + 1 }}</div>
                                            <div>{{ $dosen->nama_lengkap }}</div>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-yellow-700 bg-yellow-50 p-4 rounded">
                                Anda belum memiliki dosen pembimbing. Silahkan ajukan judul terlebih dahulu.
                            </div>
                        @endif
                    </div>
                    @error('dosen_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="tanggal_pengajuan">
                            Tanggal Bimbingan
                        </label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('tanggal_pengajuan') }}" min="{{ date('Y-m-d') }}">
                        @error('tanggal_pengajuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="waktu_pengajuan">
                            Waktu Bimbingan
                        </label>
                        <input type="time" name="waktu_pengajuan" id="waktu_pengajuan" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('waktu_pengajuan') }}">
                        @error('waktu_pengajuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="keterangan">
                        Keterangan / Topik Bahasan
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Tuliskan topik apa yang akan dibahas dalam bimbingan">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="metode">
                        Metode Bimbingan
                    </label>
                    <select name="metode" id="metode" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="online" {{ old('metode') == 'online' ? 'selected' : '' }}>Online Meeting</option>
                        <option value="offline" {{ old('metode') == 'offline' ? 'selected' : '' }}>Offline Meeting</option>
                    </select>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <button type="reset" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Reset Form
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Ajukan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- History Section -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-6xl mx-auto">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Bimbingan</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(isset($jadwalBimbingan) && count($jadwalBimbingan) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6 text-left">Dosen</th>
                                <th class="py-3 px-6 text-left">Tanggal</th>
                                <th class="py-3 px-6 text-center">Jam</th>
                                <th class="py-3 px-6 text-center">Metode Bimbingan</th>
                                <th class="py-3 px-6 text-center">Status Bimbingan</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm">
                            @foreach($jadwalBimbingan as $jadwal)
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="py-3 px-6 text-left">
                                        <div class="flex items-center">
                                            @if(isset($jadwal->dosen->gambar) && $jadwal->dosen->gambar)
                                                <div class="mr-2">
                                                    <img class="w-8 h-8 rounded-full" src="{{ asset('storage/' . $jadwal->dosen->gambar) }}" alt="{{ $jadwal->dosen->nama_lengkap }}">
                                                </div>
                                            @else
                                                <div class="mr-2 w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                            <span>{{ $jadwal->dosen->nama_lengkap }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 px-6 text-left">
                                        {{ $jadwal->tanggal_pengajuan->format('d/m/Y') }}
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        {{ $jadwal->waktu_pengajuan->format('H:i') }} WIB
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if(isset($jadwal->metode))
                                            <span class="py-1 px-3 {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }} rounded-full text-xs">
                                                {{ $jadwal->metode == 'online' ? 'Online Meeting' : 'Offline Meeting' }}
                                            </span>
                                        @else
                                            @if(strpos($jadwal->keterangan, 'Online') !== false || strpos($jadwal->keterangan, 'online') !== false)
                                                <span class="py-1 px-3 bg-blue-100 text-blue-800 rounded-full text-xs">Online Meeting</span>
                                            @else
                                                <span class="py-1 px-3 bg-purple-100 text-purple-800 rounded-full text-xs">Offline Meeting</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        @if($jadwal->status == 'diproses')
                                            <span class="py-1 px-3 bg-yellow-100 text-yellow-800 rounded-full text-xs">Diproses</span>
                                        @elseif($jadwal->status == 'diterima')
                                            <span class="py-1 px-3 bg-green-100 text-green-800 rounded-full text-xs">Disetujui</span>
                                        @elseif($jadwal->status == 'ditolak')
                                            <span class="py-1 px-3 bg-red-100 text-red-800 rounded-full text-xs">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex justify-center">
                                            <a href="{{ route('mahasiswa.jadwal-bimbingan.show', $jadwal->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded mx-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>

                                            @if($jadwal->status == 'diterima' && isset($jadwal->dokumenOnline) && count($jadwal->dokumenOnline) == 0)
                                                <a href="#" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded mx-1" title="Upload Dokumen">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0l-4 4m4-4v12" />
                                                    </svg>
                                                </a>
                                            @endif

                                            @if($jadwal->status == 'diproses')
                                                <form method="POST" action="#" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded mx-1" onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal bimbingan ini?')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
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
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
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
</div>
@endsection
