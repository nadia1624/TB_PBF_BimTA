@extends('layouts.app')

@section('content')
    <div class="w-full bg-gray-100 py-8 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-8">Status Tugas Akhir</h2>

                @if ($statusBimbingan !== 'belum_mengajukan')
                    {{-- Grid Layout untuk form fields --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        {{-- Judul Tugas Akhir --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Judul Tugas Akhir</label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
                                value="{{ optional($pengajuanJudul)->judul ?? 'N/A' }}" readonly>
                        </div>

                        {{-- Dosen Pembimbing 1 --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Dosen Pembimbing 1</label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
                                value="{{ $pembimbing1 }}" readonly>
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Status</label>
                            @if ($statusBimbingan === 'selesai')
                                <button class="px-4 py-2 bg-green-200 text-green-800 rounded-md font-medium cursor-default">
                                    Sudah Selesai
                                </button>
                            @elseif ($statusBimbingan === 'pending')
                                {{-- Cek apakah ada penolakan dari dosen pembimbing --}}
                                @php
                                    $dosenMenolak = false;
                                    if ($pengajuanJudul) {
                                        $details = $pengajuanJudul->detailDosen;
                                        $pembimbing1Detail = $details->where('pembimbing', 'pembimbing 1')->first();
                                        $pembimbing2Detail = $details->where('pembimbing', 'pembimbing 2')->first();

                                        $dosenMenolak = ($pembimbing1Detail && $pembimbing1Detail->status === 'ditolak') ||
                                                       ($pembimbing2Detail && $pembimbing2Detail->status === 'ditolak');
                                    }
                                @endphp

                                @if ($dosenMenolak)
                                    <button class="px-4 py-2 bg-orange-200 text-orange-800 rounded-md font-medium cursor-default">
                                        Ditolak Dosen
                                    </button>
                                @else
                                    <button class="px-4 py-2 bg-yellow-200 text-yellow-800 rounded-md font-medium cursor-default">
                                        Dalam Proses
                                    </button>
                                @endif
                            @elseif ($statusBimbingan === 'dibatalkan')
                                <button class="px-4 py-2 bg-red-200 text-red-800 rounded-md font-medium cursor-default">
                                    Dibatalkan
                                </button>
                            @endif
                        </div>

                        {{-- Dosen Pembimbing 2 --}}
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Dosen Pembimbing 2</label>
                            <input type="text"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
                                value="{{ $pembimbing2 }}" readonly>
                        </div>
                    </div>

                    {{-- Status Message Box --}}
                    <div class="mt-6 p-4 rounded-md">
                        @if ($statusBimbingan === 'selesai')
                            <div class="bg-green-100 border border-green-300 p-4 rounded-md">
                                <p class="text-green-800 font-medium mb-2">Tugas akhir anda sudah di-review dan sudah disetujui</p>
                                <p class="text-green-700">Anda sudah menyelesaikan tugas akhir dengan Dosen {{ $pembimbing1 }} dan Dosen {{ $pembimbing2 }}</p>
                            </div>
                        @elseif ($statusBimbingan === 'pending')
                            {{-- Cek lagi apakah ada penolakan dari dosen pembimbing --}}
                            @php
                                $dosenMenolak = false;
                                $dosenPenolak = [];
                                if ($pengajuanJudul) {
                                    $details = $pengajuanJudul->detailDosen;
                                    $pembimbing1Detail = $details->where('pembimbing', 'pembimbing 1')->first();
                                    $pembimbing2Detail = $details->where('pembimbing', 'pembimbing 2')->first();

                                    if ($pembimbing1Detail && $pembimbing1Detail->status === 'ditolak') {
                                        $dosenMenolak = true;
                                        $dosenPenolak[] = $pembimbing1Detail->dosen->nama_lengkap ?? 'Pembimbing 1';
                                    }
                                    if ($pembimbing2Detail && $pembimbing2Detail->status === 'ditolak') {
                                        $dosenMenolak = true;
                                        $dosenPenolak[] = $pembimbing2Detail->dosen->nama_lengkap ?? 'Pembimbing 2';
                                    }
                                }
                            @endphp

                            @if ($dosenMenolak)
                                <div class="bg-orange-100 border border-orange-300 p-4 rounded-md">
                                    <p class="text-orange-800 font-medium mb-2">Pengajuan Judul Ditolak oleh Dosen Pembimbing</p>
                                    <p class="text-orange-700">Pengajuan judul Anda ditolak oleh: <strong>{{ implode(' dan ', $dosenPenolak) }}</strong></p>
                                    <p class="text-orange-600 text-sm mt-2">Silakan ajukan judul baru atau hubungi dosen pembimbing untuk penjelasan lebih lanjut.</p>
                                </div>
                            @else
                                <div class="bg-yellow-100 border border-yellow-300 p-4 rounded-md">
                                    <p class="text-yellow-800">{{ $messageBimbingan }}</p>
                                </div>
                            @endif
                        @elseif ($statusBimbingan === 'dibatalkan')
                            <div class="bg-red-100 border border-red-300 p-4 rounded-md">
                                <p class="text-red-800 font-medium mb-2">Pengajuan Judul Dibatalkan</p>
                                <p class="text-red-700">{{ $messageBimbingan }}</p>
                                <p class="text-red-600 text-sm mt-2">Pengajuan ini telah dibatalkan secara resmi oleh sistem.</p>
                            </div>
                        @endif
                    </div>

                @else
                    {{-- Tampilkan pesan jika belum mengajukan --}}
                    <div class="bg-yellow-50 border border-yellow-200 p-6 rounded-md">
                        <p class="text-yellow-800 font-medium mb-4">{{ $messageBimbingan }}</p>
                        <a href="{{ route('mahasiswa.pengajuan-judul.index') }}"
                           class="inline-block px-6 py-3 bg-yellow-500 text-white font-medium rounded-md hover:bg-yellow-600 transition-colors duration-200">
                            Lakukan Pengajuan Judul
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
