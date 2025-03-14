@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-4xl mx-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Detail Jadwal Bimbingan</h2>
                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
            </div>

            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Informasi Bimbingan</h3>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Tanggal Bimbingan</p>
                            <p class="font-medium">{{ $jadwalBimbingan->tanggal_pengajuan->format('d F Y') }}</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Waktu Bimbingan</p>
                            <p class="font-medium">{{ $jadwalBimbingan->waktu_pengajuan->format('H:i') }} WIB</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Status</p>
                            <div>
                                @if($jadwalBimbingan->status == 'diproses')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="mr-1.5 h-2 w-2 text-yellow-600" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Diproses
                                    </span>
                                @elseif($jadwalBimbingan->status == 'diterima')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="mr-1.5 h-2 w-2 text-green-600" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Disetujui
                                    </span>
                                @elseif($jadwalBimbingan->status == 'ditolak')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                        <svg class="mr-1.5 h-2 w-2 text-red-600" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Dosen Pembimbing</h3>
                        <div class="flex items-center mb-4">
                            @if($jadwalBimbingan->dosen->gambar)
                                <img class="h-12 w-12 rounded-full mr-3" src="{{ asset('storage/' . $jadwalBimbingan->dosen->gambar) }}" alt="{{ $jadwalBimbingan->dosen->nama_lengkap }}">
                            @else
                                <div class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <p class="font-semibold">{{ $jadwalBimbingan->dosen->nama_lengkap }}</p>
                                <p class="text-sm text-gray-500">{{ $jadwalBimbingan->dosen->nip }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-500">Bidang Keahlian</p>
                            <div class="flex flex-wrap gap-2 mt-1">
                                @foreach($jadwalBimbingan->dosen->bidangKeahlian as $bidang)
                                    <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded">
                                        {{ $bidang->nama_keahlian }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Keterangan / Topik Bahasan</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="whitespace-pre-line">{{ $jadwalBimbingan->keterangan }}</p>
                </div>
            </div>

            @if($jadwalBimbingan->status == 'ditolak')
                <div class="mb-6">
                    <div class="bg-red-50 border-l-4 border-red-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm leading-5 font-medium text-red-800">
                                    Jadwal Bimbingan Ditolak
                                </h3>
                                <div class="mt-2 text-sm leading-5 text-red-700">
                                    <p>{{ $jadwalBimbingan->keterangan_dosen ?? 'Tidak ada keterangan tambahan dari dosen.' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if(count($jadwalBimbingan->dokumenOnline) > 0)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-3">Dokumen Bimbingan</h3>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <ul class="divide-y divide-gray-200">
                            @foreach($jadwalBimbingan->dokumenOnline as $dokumen)
                                <li class="py-3">
                                    <div class="flex justify-between">
                                        <div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dokumen->bab == 'lengkap' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                                {{ ucfirst($dokumen->bab) }}
                                            </span>
                                            <p class="mt-1 text-sm text-gray-600">
                                                {{ $dokumen->keterangan_mahasiswa }}
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $dokumen->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' : ($dokumen->status == 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                {{ ucfirst($dokumen->status) }}
                                            </span>
                                            <a href="{{ asset('storage/' . $dokumen->dokumen_mahasiswa) }}" target="_blank" class="ml-3 text-blue-600 hover:text-blue-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </a>
                                        </div>
                                    </div>

                                    @if($dokumen->dokumen_dosen)
                                        <div class="mt-3 ml-6 p-3 bg-white rounded border border-gray-200">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="text-sm text-gray-700">Dosen telah memberi feedback pada {{ \Carbon\Carbon::parse($dokumen->tanggal_review)->format('d F Y') }}</span>
                                                <a href="{{ asset('storage/' . $dokumen->dokumen_dosen) }}" target="_blank" class="ml-auto text-blue-600 hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </a>
                                            </div>
                                            @if($dokumen->keterangan_dosen)
                                                <p class="mt-2 text-sm text-gray-600">{{ $dokumen->keterangan_dosen }}</p>
                                            @endif
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if($jadwalBimbingan->status == 'diterima' && count($jadwalBimbingan->dokumenOnline) == 0)
                <div class="mt-8 flex justify-center">
                    <a href="#" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Upload Dokumen Bimbingan
                    </a>
                </div>
            @endif

            <div class="mt-8 border-t pt-6">
                <div class="flex justify-between">
                    <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="text-gray-600 hover:text-gray-800">
                        Kembali ke Daftar Bimbingan
                    </a>

                    @if($jadwalBimbingan->status == 'diproses')
                        <form method="POST" action="#" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal bimbingan ini?')">
                                Batalkan Pengajuan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
