@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-b from-gray-50 to-gray-100 py-12 px-4 min-h-screen">
    <div class="bg-white rounded-lg shadow-md overflow-hidden max-w-6xl mx-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <a href="javascript:history.back()" class="text-blue-600 hover:text-blue-800 flex items-center">
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
                                {{ $jadwal->metode == 'online' ? 'Online Meeting' : 'Offline Meeting' }}
                            </span>
                        </div>
                        <div class="mt-4">
                            @php
                                // Definisikan status untuk ditampilkan
                                $displayStatus = $jadwal->status;
                                $statusClass = '';

                                // Jika metode online dan status diterima, cek dokumen online
                                if ($jadwal->metode == 'online' && $jadwal->status == 'diterima') {
                                    if ($jadwal->dokumenOnline) {
                                        $displayStatus = $jadwal->dokumenOnline->status;
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
                            if ($jadwal->dokumenOnline) {
                                $selectedBab = $jadwal->dokumenOnline->bab ?? 'bab 1';
                            } else {
                                $selectedBab = 'bab 1'; // Default value
                            }

                            // Menentukan apakah halaman dalam mode read-only
                            $isReadOnly = $jadwal->status != 'diterima' ||
                                        ($jadwal->dokumenOnline && $jadwal->dokumenOnline->status != 'menunggu');
                        @endphp

                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'bab 1' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="bab 1"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">BAB I</h4>
                                <p class="text-sm text-gray-500">Pendahuluan</p>
                            </div>
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'bab 2' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="bab 2"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">BAB II</h4>
                                <p class="text-sm text-gray-500">Landasan Teori</p>
                            </div>
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'bab 3' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="bab 3"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">BAB III</h4>
                                <p class="text-sm text-gray-500">Metodologi</p>
                            </div>
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'bab 4' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="bab 4"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">BAB IV</h4>
                                <p class="text-sm text-gray-500">Hasil dan Pembahasan</p>
                            </div>
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'bab 5' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="bab 5"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">BAB V</h4>
                                <p class="text-sm text-gray-500">Kesimpulan</p>
                            </div>
                            <div class="p-4 border rounded-lg bab-item {{ $selectedBab == 'lengkap' ? 'bg-blue-50 border-blue-300 selected' : 'bg-white border-gray-200' }} {{ !$isReadOnly ? 'cursor-pointer' : '' }}"
                                data-bab="lengkap"
                                {{ $isReadOnly ? 'style=pointer-events:none;' : '' }}>
                                <h4 class="font-semibold">Lengkap</h4>
                                <p class="text-sm text-gray-500">Dokumen Lengkap</p>
                            </div>
                        </div>

                        <!-- Tampilkan Dokumen yang Sudah Diupload (Read-Only Mode) -->
                        @if($jadwal->dokumenOnline && $jadwal->dokumenOnline->dokumen_mahasiswa)
                            <div class="mb-6">
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="text-base font-medium text-gray-700 mb-3">Dokumen yang Diupload</h4>

                                    <div class="mb-4 pb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <div>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ ucfirst($jadwal->dokumenOnline->bab) }}
                                                </span>
                                                <span class="ml-2 text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($jadwal->dokumenOnline->created_at)->format('d F Y H:i') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="flex items-center mb-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
                                            </svg>
                                            <a href="{{ asset('storage/' . $jadwal->dokumenOnline->dokumen_mahasiswa) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                                {{ basename($jadwal->dokumenOnline->dokumen_mahasiswa) }}
                                            </a>
                                        </div>

                                        <div class="text-sm text-gray-600">
                                            <p class="font-medium mb-1">Keterangan:</p>
                                            <p>{{ $jadwal->dokumenOnline->keterangan_mahasiswa ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Form Upload File -->
                        @if($jadwal->metode == 'online' && $jadwal->status == 'diterima' &&
                        (!$jadwal->dokumenOnline ||
                        ($jadwal->dokumenOnline && $jadwal->dokumenOnline->status == 'menunggu')))
                        <div class="mb-6">
                            <div class="border border-gray-200 rounded-lg p-4">
                                <form method="POST" action="{{ route('mahasiswa.jadwal-bimbingan.upload-dokumen', $jadwal->id) }}" enctype="multipart/form-data" id="uploadForm">
                                    @csrf
                                    <input type="hidden" name="bab" id="selectedBab" value="{{ $selectedBab }}">

                                    <!-- Debug info -->
                                    <div class="mb-2 p-2 bg-yellow-50 rounded text-xs text-yellow-800" id="debugInfo">
                                        Selected BAB: <span id="debugBab">{{ $selectedBab }}</span>
                                    </div>

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
                            <p class="whitespace-pre-line">{{ $jadwal->keterangan_diterima_offline }}</p>
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

                    <!-- Balasan Dosen - Hanya untuk metode online -->
                    @if($jadwal->metode == 'online')
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Balasan Dosen</h3>
                            <div class="p-4 bg-gray-50 rounded-lg min-h-48">
                                @if($jadwal->dokumenOnline)
                                    @php
                                        $dokumenReview = $jadwal->dokumenOnline;
                                    @endphp

                                    @if($dokumenReview->dokumen_dosen)
                                        <div class="mb-4">
                                            <p class="text-sm text-gray-700">
                                                {{ $dokumenReview->keterangan_dosen ?? 'Tidak ada catatan tambahan dari dosen.' }}
                                            </p>
                                            <div class="mt-2">
                                                <a href="{{ route('mahasiswa.dokumen.review.download', $dokumenReview->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                    Download Dokumen Revisi dari Dosen
                                                </a>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Direview pada: {{ optional($dokumenReview->tanggal_review)->format('d F Y H:i') ?? 'Tanggal tidak tersedia' }}
                                                </p>
                                            </div>
                                        </div>
                                    @elseif($dokumenReview->keterangan_dosen)
                                        <p class="text-sm text-gray-700">
                                            {{ $dokumenReview->keterangan_dosen }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Direview pada: {{ optional($dokumenReview->tanggal_review)->format('d F Y H:i') ?? 'Tanggal tidak tersedia' }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">Dosen belum memberikan balasan review untuk dokumen ini.</p>
                                    @endif
                                @else
                                    <p class="text-sm text-gray-500">Dokumen bimbingan belum diupload atau belum direview oleh dosen.</p>
                                @endif
                            </div>
                        </div>
                    @endif
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
    console.log('DOM loaded, initializing bab selector...');

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

    // Handle bab selection dengan event delegation dan perbaikan
    const babItems = document.querySelectorAll('.bab-item');
    const selectedBabInput = document.getElementById('selectedBab');
    const debugBab = document.getElementById('debugBab');

    console.log('Found bab items:', babItems.length);
    console.log('Current selected bab:', selectedBabInput ? selectedBabInput.value : 'not found');

    babItems.forEach((item, index) => {
        // Cek apakah item bisa diklik (tidak read-only)
        if (item.style.pointerEvents !== 'none' && item.classList.contains('cursor-pointer')) {
            console.log(`Setting up click handler for item ${index}:`, item.getAttribute('data-bab'));

            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const selectedBab = this.getAttribute('data-bab');
                console.log('Bab clicked:', selectedBab);

                // Remove active class from all bab elements
                babItems.forEach(el => {
                    el.classList.remove('bg-blue-50', 'border-blue-300', 'selected');
                    el.classList.add('bg-white', 'border-gray-200');
                });

                // Add active class to clicked element
                this.classList.remove('bg-white', 'border-gray-200');
                this.classList.add('bg-blue-50', 'border-blue-300', 'selected');

                // Set selected bab value
                if (selectedBabInput) {
                    selectedBabInput.value = selectedBab;
                    console.log('Updated hidden input value to:', selectedBab);
                }

                // Update debug info
                if (debugBab) {
                    debugBab.textContent = selectedBab;
                }
            });
        }
    });

    // Form validation dengan debug yang lebih detail
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', function(e) {
            const dokumen = document.getElementById('dokumen');
            const babValue = selectedBabInput ? selectedBabInput.value : '';

            console.log('Form submit - Selected BAB:', babValue);
            console.log('Form submit - File selected:', dokumen && dokumen.files.length > 0);

            if (!dokumen || dokumen.files.length === 0) {
                e.preventDefault();
                alert('Silakan pilih file terlebih dahulu');
                return false;
            }

            if (!babValue) {
                e.preventDefault();
                alert('Silakan pilih BAB terlebih dahulu');
                return false;
            }

            console.log('Form validation passed, submitting...');
            return true;
        });
    }
});
</script>
@endsection
