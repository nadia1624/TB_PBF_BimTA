@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 min-h-screen">
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-6xl mx-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <a href="{{ route('mahasiswa.jadwal-bimbingan.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Header dengan nama dosen dan status -->
            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    <div class="div">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $jadwal->dosen->nama_lengkap }}</h2>
                        @php
                            $jenisPembimbing = $jadwal->pengajuanJudul->dosen()
                                ->wherePivot('dosen_id', $jadwal->dosen_id)
                                ->first()
                                ->pivot
                                ->jenis_pembimbing ?? '';
                        @endphp
                        <p class="text-base text-gray-600">Pembimbing {{ $jenisPembimbing }}</p>

                        <p class="text-base text-gray-500 mt-1">{{ $jadwal->tanggal_pengajuan->format('d') }} {{ $jadwal->tanggal_pengajuan->format('F') }}  {{ $jadwal->tanggal_pengajuan->format('Y') }} • {{ $jadwal->waktu_pengajuan->format('H:i') }} WIB</p>
                    </div>

                    <div class="div">
                        <div>
                            <span class="px-4 py-2 rounded-md text-sm font-medium bg-blue-50 text-blue-700">
                                {{ $jadwal->metode == 'online' ? 'Online Meeting' : 'Tatap Muka' }}
                            </span>
                        </div>
                        <div class="mt-4">
                            @php
                                // Definisikan status untuk ditampilkan
                                $displayStatus = $jadwal->status;
                                $statusClass = '';

                                // Jika metode online dan status diterima, cek dokumen online
                                if ($jadwal->metode == 'online' && $jadwal->status == 'diterima') {
                                    $dokumenOnline = $jadwal->dokumenOnline->first();
                                    if ($dokumenOnline) {
                                        $displayStatus = $dokumenOnline->status;
                                    } else {
                                        $displayStatus = 'menunggu';
                                    }
                                }

                                // Set warna status
                                switch ($displayStatus) {
                                    case 'menunggu':
                                        $statusClass = 'bg-orange-100 text-orange-700';
                                        break;
                                    case 'diproses':
                                        $statusClass = 'bg-yellow-100 text-yellow-700';
                                        break;
                                    case 'diterima':
                                        $statusClass = 'bg-green-100 text-green-700';
                                        break;
                                    case 'ditolak':
                                        $statusClass = 'bg-red-100 text-red-700';
                                        break;
                                    case 'selesai':
                                        $statusClass = 'bg-green-100 text-green-700';
                                        break;
                                    default:
                                        $statusClass = 'bg-gray-100 text-gray-700';
                                }
                            @endphp
                            <span class="inline-block px-4 py-2 w-full rounded-md text-sm font-medium {{ $statusClass }}">
                                {{ ucfirst($displayStatus) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <hr class="my-6">

            <!-- Konten Utama -->
            <div class="flex flex-col md:flex-row">
                <!-- Kolom kiri (Bab dan Upload) -->
                <div class="w-full md:w-1/2 md:pr-6">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Bimbingan TA</h3>

                    @if($jadwal->metode == 'online')
                        <!-- Daftar Bab -->
                        @php
                            // Cek bab yang dipilih jika ada dokumen
                            $selectedBab = '';
                            if ($jadwal->dokumenOnline->count() > 0) {
                                $selectedBab = $jadwal->dokumenOnline->first()->bab;
                            } else {
                                $selectedBab = 'bab 1'; // Default value
                            }

                            // Menentukan apakah halaman dalam mode read-only
                            $isReadOnly = $jadwal->status != 'diterima' || $jadwal->dokumenOnline->count() > 0;
                        @endphp

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'bab 1' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=bab 1' : '' }}>
                                <h4 class="font-semibold">BAB I</h4>
                                <p class="text-sm text-gray-500">Pendahuluan</p>
                            </div>
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'bab 2' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=bab 2' : '' }}>
                                <h4 class="font-semibold">BAB II</h4>
                                <p class="text-sm text-gray-500">Landasan Teori</p>
                            </div>
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'bab 3' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=bab 3' : '' }}>
                                <h4 class="font-semibold">BAB III</h4>
                                <p class="text-sm text-gray-500">Metodologi</p>
                            </div>
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'bab 4' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=bab 4' : '' }}>
                                <h4 class="font-semibold">BAB IV</h4>
                                <p class="text-sm text-gray-500">Hasil dan Pembahasan</p>
                            </div>
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'bab 5' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=bab 5' : '' }}>
                                <h4 class="font-semibold">BAB V</h4>
                                <p class="text-sm text-gray-500">Kesimpulan</p>
                            </div>
                            <div class="p-4 border rounded-lg {{ $selectedBab == 'lengkap' ? 'bg-blue-50 border-blue-300' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer bab-selector' : '' }}" {{ !$isReadOnly ? 'data-bab=lengkap' : '' }}>
                                <h4 class="font-semibold">Lengkap</h4>
                                <p class="text-sm text-gray-500">Dokumen Lengkap</p>
                            </div>
                        </div>

                        <!-- Tampilkan Dokumen yang Sudah Diupload (Read-Only Mode) -->
                        @if($jadwal->dokumenOnline->count() > 0)
                            <div class="mb-6">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-base font-medium text-gray-700 mb-3">Dokumen yang Diupload</h4>

                                    @foreach($jadwal->dokumenOnline as $dokumen)
                                        <div class="mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                                            <div class="flex justify-between items-center mb-2">
                                                <div>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ ucfirst($dokumen->bab) }}
                                                    </span>
                                                    <span class="ml-2 text-sm text-gray-500">
                                                        {{ \Carbon\Carbon::parse($dokumen->created_at)->format('d F Y H:i') }}
                                                    </span>
                                                </div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                                    {{ $dokumen->status == 'menunggu' ? 'bg-yellow-100 text-yellow-800' :
                                                    ($dokumen->status == 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($dokumen->status) }}
                                                </span>
                                            </div>

                                            <div class="flex items-center mb-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                                </svg>
                                                <a href="{{ asset('storage/' . $dokumen->dokumen_mahasiswa) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                    {{ basename($dokumen->dokumen_mahasiswa) }}
                                                </a>
                                            </div>

                                            <div class="text-sm text-gray-600">
                                                <p class="font-medium mb-1">Keterangan:</p>
                                                <p>{{ $dokumen->keterangan_mahasiswa }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Form Upload File (Visible only if status = diterima and no document yet) -->
                        @if($jadwal->metode == 'online' && $jadwal->status == 'diterima' && $jadwal->dokumenOnline->count() == 0)
                            <div class="mb-6">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.upload-dokumen', $jadwal->id) }}" enctype="multipart/form-data" id="uploadForm">
                                        @csrf
                                        <input type="hidden" name="bab" id="selectedBab" value="{{ $selectedBab }}">

                                        <div class="mb-4">
                                            <label for="dokumen" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                                            <div class="flex items-center">
                                                <button type="button" onclick="document.getElementById('dokumen').click()" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                    Upload
                                                </button>
                                                <span id="file-selected" class="ml-3 text-sm text-gray-500">Belum ada file dipilih</span>
                                            </div>
                                            <input id="dokumen" name="dokumen" type="file" class="hidden" accept=".pdf,.doc,.docx">
                                        </div>

                                        <div class="mb-4">
                                            <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan</label>
                                            <textarea id="keterangan" name="keterangan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm" placeholder="Tambahkan keterangan untuk dokumen ini"></textarea>
                                        </div>

                                        <div class="flex justify-end">
                                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                Ajukan Dokumen
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endif
                    @else
                        <!-- Tampilan untuk metode offline -->
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center text-gray-600 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v3.586L7.707 9.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 10.586V7z" clip-rule="evenodd" />
                                </svg>
                                <span>Bimbingan Tatap Muka</span>
                            </div>
                            <p class="text-sm text-gray-500">
                                Bimbingan ini dilakukan secara tatap muka. Silahkan datang ke ruangan dosen sesuai dengan jadwal yang telah disepakati.
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Kolom kanan (Topik dan Balasan) -->
                <div class="w-full md:w-1/2 md:pl-6 md:border-l">
                    <!-- Topik Bahasan -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Topik Bahasan:</h3>
                        <div class="p-4 bg-gray-50 rounded-lg">
                            <p class="whitespace-pre-line">{{ $jadwal->keterangan }}</p>
                        </div>
                    </div>

                    <!-- Balasan Dosen -->
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Balasan Dosen</h3>
                        <div class="p-4 bg-gray-50 rounded-lg min-h-48">
                            @if($jadwal->dokumenOnline->where('dokumen_dosen', '!=', null)->count() > 0)
                                @foreach($jadwal->dokumenOnline->where('dokumen_dosen', '!=', null) as $dokumen)
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-700">{{ $dokumen->keterangan_dosen ?? 'Tidak ada keterangan tambahan.' }}</p>
                                        <div class="mt-2">
                                            <a href="{{ asset('storage/' . $dokumen->dokumen_dosen) }}" target="_blank" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                                Download Dokumen Revisi
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @elseif($jadwal->status == 'ditolak')
                                <p class="text-sm text-red-600">{{ $jadwal->keterangan_dosen ?? 'Jadwal bimbingan ditolak.' }}</p>
                            @else
                                <p class="text-sm text-gray-500">Belum ada balasan dari dosen.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-8 border-t pt-6 flex justify-end">
                @if($jadwal->status == 'diproses')
                    <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.destroy', $jadwal->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Apakah Anda yakin ingin membatalkan jadwal bimbingan ini?')">
                            Batalkan Pengajuan
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle file selection
    const fileInput = document.getElementById('dokumen');
    const fileSelected = document.getElementById('file-selected');

    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (fileInput.files.length > 0) {
                fileSelected.textContent = fileInput.files[0].name;
            } else {
                fileSelected.textContent = 'Belum ada file dipilih';
            }
        });
    }

    // Handle bab selection
    const babSelectors = document.querySelectorAll('.bab-selector');
    const selectedBabInput = document.getElementById('selectedBab');

    babSelectors.forEach(selector => {
        selector.addEventListener('click', function() {
            // Remove active class from all bab elements
            babSelectors.forEach(el => {
                el.classList.remove('bg-blue-50', 'border-blue-300');
                el.classList.add('bg-white', 'border-gray-200');
            });

            // Add active class to clicked element
            this.classList.remove('bg-white', 'border-gray-200');
            this.classList.add('bg-blue-50', 'border-blue-300');

            // Set selected bab value
            selectedBabInput.value = this.getAttribute('data-bab');
        });
    });

    // Form validation
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const dokumen = document.getElementById('dokumen');
            if (dokumen.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file terlebih dahulu');
                return false;
            }
            return true;
        });
    }
});
</script>
@endsection
