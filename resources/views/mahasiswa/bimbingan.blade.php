@extends('layouts.app')

@section('content')
    <div class="w-full bg-gray-100 py-8 px-4">
        <div class="max-w-6xl mx-auto space-y-8">

            <!-- Bimbingan Disetujui Section -->
            @if ($statusBimbingan !== 'belum_mengajukan' && isset($jadwalBimbingan) && count($jadwalBimbingan) > 0)
                <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl">
                    <div class="border-b border-gray-100">
                        <div class="px-8 py-5">
                            <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Bimbingan Disetujui
                            </h2>
                        </div>
                    </div>

                    <div class="p-6">
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
                                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Disetujui
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                                <div class="flex justify-center">
                                                    <!-- Tombol untuk melihat detail bimbingan -->
                                                    <a href="{{ route('mahasiswa.jadwal-bimbingan.show', $jadwal->id) }}"
                                                       class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                        </svg>
                                                        Bimbingan
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Tugas Akhir Section -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden transition-all duration-300 hover:shadow-xl p-8">
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
