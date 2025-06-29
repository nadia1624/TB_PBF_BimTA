@extends('layouts.dosen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dokumen Bimbingan</h1>

    <!-- Enhanced Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <!-- Total Dokumen Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-gray-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Total Dokumen</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalDokumen }}</p>
                    <p class="text-xs text-gray-500">Semua dokumen yang tersedia</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-gray-500 to-gray-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perlu Review Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-yellow-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Perlu Review</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $perluReview }}</p>
                    <p class="text-xs text-gray-500">Dokumen menunggu review</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sudah Direview Card -->
        {{-- <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-green-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Sudah Direview</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $sudahReview }}</p>
                    <p class="text-xs text-gray-500">Dokumen telah selesai direview</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

<div class="space-y-6">
    <!-- Filter Section -->
    <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
        <div class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label for="bab-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Berdasarkan Bab</label>
                <div class="relative">
                    <select id="bab-filter" class="appearance-none bg-white border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-10 shadow-sm transition-colors">
                        <option value="">📚 Semua Bab</option>
                        <option value="bab 1">📄 Bab 1 - Pendahuluan</option>
                        <option value="bab 2">📊 Bab 2 - Tinjauan Pustaka</option>
                        <option value="bab 3">🔬 Bab 3 - Metodologi</option>
                        <option value="bab 4">📈 Bab 4 - Hasil & Pembahasan</option>
                        <option value="bab 5">🎯 Bab 5 - Kesimpulan</option>
                        <option value="lengkap">✅ Dokumen Lengkap</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex-1">
                <label for="status-filter" class="block text-sm font-medium text-gray-700 mb-2">Filter Status</label>
                <div class="relative">
                    <select id="status-filter" class="appearance-none bg-white border border-gray-300 text-gray-800 text-sm rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block w-full p-3 pr-10 shadow-sm transition-colors">
                        <option value="">🔄 Semua Status</option>
                        <option value="menunggu">⏳ Belum Direview</option>
                        <option value="diproses">🔍 Perlu Review</option>
                        <option value="selesai">✅ Sudah Direview</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents List -->
    <div id="dokumen-list" class="space-y-4">
        @forelse($dokumen->whereIn('status', ['menunggu', 'diproses'])->concat($dokumen->where('status', 'selesai')->where('bab', 'lengkap')->filter(function($item) {
    return $item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->approved_ta === 'pending';
})) as $item)
<div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-shadow document-item"
     data-status="{{ $item->status }}"
     data-bab="{{ $item->bab ?? '' }}">

    <!-- Header Card -->
    <div class="p-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <!-- Student Info -->
            <div class="flex items-center space-x-3">
                @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->mahasiswa)
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                        {{ substr($item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'X', 0, 1) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm">
                            {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'Nama tidak tersedia' }}
                        </h3>
                        <p class="text-xs text-gray-600">
                            {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nim ?? 'NIM tidak tersedia' }}
                        </p>
                    </div>
                @else
                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-semibold text-sm flex-shrink-0">
                        ?
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 text-sm">Data tidak tersedia</h3>
                        <p class="text-xs text-gray-600">Informasi mahasiswa belum lengkap</p>
                    </div>
                @endif
            </div>

            <!-- Status & Date -->
            <div class="flex items-center space-x-3">
                <!-- Status Badge -->
                @if($item->status == 'menunggu')
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full mr-1"></span>
                        Belum Direview
                    </span>
                @elseif($item->status == 'diproses')
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1"></span>
                        Perlu Review
                    </span>
                @elseif($item->status == 'selesai')
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1"></span>
                        Selesai
                    </span>
                @endif

                <!-- Date -->
                <div class="flex items-center text-xs text-gray-500">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d M Y') }}
                </div>
            </div>
        </div>

        <!-- Judul TA -->
        @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul)
        <div class="mt-3 p-2 bg-gray-50 rounded-md">
            <p class="text-xs text-gray-600 mb-1">Judul Tugas Akhir:</p>
            <p class="text-sm font-medium text-gray-800 leading-relaxed">
                {{ $item->jadwalBimbingan->pengajuanJudul->judul ?? 'Judul tidak tersedia' }}
            </p>
        </div>
        @endif
    </div>

    <!-- Content -->
    <div class="p-4">
        @if($item->dokumen_mahasiswa)
            <!-- Document Info -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-2">
                    @php
                        $babIcon = [
                            'bab 1' => '📄',
                            'bab 2' => '📊',
                            'bab 3' => '🔬',
                            'bab 4' => '📈',
                            'bab 5' => '🎯',
                            'lengkap' => '✅'
                        ];
                        $icon = $babIcon[$item->bab] ?? '📄';
                    @endphp
                    <span class="text-lg">{{ $icon }}</span>
                    <span class="text-sm font-medium text-gray-700">
                        {{ ucfirst($item->bab ?? 'Dokumen') }}
                    </span>
                </div>
                <span class="text-xs text-gray-500">
                    {{ basename($item->dokumen_mahasiswa) }}
                </span>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-2 mb-4">
                <!-- View Button -->
                <a href="{{ route('dosen.dokumen.online.view', $item->id) }}"
                   class="inline-flex items-center px-3 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-medium rounded-md transition-colors"
                   target="_blank">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542-7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Lihat
                </a>

                <!-- Download Button -->
                <a href="{{ route('dosen.dokumen.online.download', $item->id) }}"
                   class="inline-flex items-center px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-700 text-xs font-medium rounded-md transition-colors">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download
                </a>

                <!-- Review Button -->
                @if($item->status != 'selesai')
                <button class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-md transition-colors open-review-modal"
                        data-id="{{ $item->id }}"
                        data-current-status="{{ $item->status }}"
                        data-catatan-review="{{ $item->keterangan_dosen ?? '' }}"
                        data-dokumen-review-path="{{ $item->dokumen_dosen ?? '' }}">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width Stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Review
                </button>
                @endif

                <!-- ACC Button -->
                @if($item->dokumen_mahasiswa && $item->bab === 'lengkap')
                    <button class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-medium rounded-md transition-colors acc-button"
                            data-id="{{ $item->id }}"
                            data-action="{{ route('dosen.dokumen.online.acc', $item->id) }}">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        ACC Tugas Akhir
                    </button>
                @endif
            </div>

            <!-- Review Response (jika ada) -->
            @if($item->keterangan_dosen || $item->dokumen_dosen)
            <div class="mt-4 p-3 bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg border border-gray-200">
                <div class="flex items-center mb-2">
                    <svg class="w-4 h-4 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 Cuban 0 012-2z"></path>
                    </svg>
                    <h4 class="text-sm font-semibold text-gray-700">Balasan Review</h4>
                </div>
                <p class="text-xs text-gray-700 leading-relaxed mb-2">
                    {{ $item->keterangan_dosen ?? 'Belum ada catatan review.' }}
                </p>
                @if($item->dokumen_dosen)
                    <a href="{{ route('dosen.dokumen.online.download.dosen', $item->id) }}"
                       class="inline-flex items-center text-xs text-blue-600 hover:text-blue-800 font-medium">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        File Review Dosen
                    </a>
                @endif
                <p class="text-xs text-gray-500 mt-2">
                    Review: {{ \Carbon\Carbon::parse($item->tanggal_review)->format('d M Y, H:i') }}
                </p>
            </div>
            @endif
        @else
            <!-- No Document Warning -->
            <div class="p-4 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-yellow-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Mahasiswa belum mengupload dokumen untuk sesi ini.</span>
                </div>
            </div>
        @endif
    </div>
</div>
@empty
<div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
    <div class="flex justify-center mb-4">
        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada dokumen</h3>
    <p class="text-gray-600">Tidak ada dokumen bimbingan yang perlu direview saat ini.</p>
</div>
@endforelse
    </div>
</div>

<div id="reviewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-md mx-4 md:mx-auto">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Review Dokumen</h2>
        <form id="reviewForm" action="" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="modal-dokumen-id">

            <div class="mb-4">
                <label for="upload_file_review" class="block text-sm font-medium text-gray-700 mb-1">Upload File Review (Opsional)</label>
                <div class="flex">
                    <label for="file_review_input" class="w-full flex items-center">
                        <input
                            type="text"
                            readonly
                            id="file_review_name"
                            class="w-full border border-gray-300 bg-gray-50 rounded-l px-3 py-2"
                            placeholder="Tidak ada file dipilih"
                        >
                        <span class="bg-white border border-gray-300 border-l-0 rounded-r px-4 py-2 inline-flex items-center text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">
                            Pilih File
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </span>
                    </label>
                    <input
                        type="file"
                        id="file_review_input"
                        name="dokumen_review"
                        class="hidden"
                        accept=".pdf,.doc,.docx,.zip"
                        onchange="document.getElementById('file_review_name').value = this.files[0].name"
                    >
                </div>
                <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC/X, ZIP. Maksimal ukuran: 5MB</p>
                <div id="current-file-review-section" class="mt-2 text-sm text-gray-600 hidden">
                    File saat ini: <a href="#" id="current-file-review-link" target="_blank" class="text-blue-600 hover:underline"></a>
                </div>
            </div>

            <div class="mb-6">
                <label for="catatan_review" class="block text-sm font-medium text-gray-700 mb-1">Catatan Review</label>
                <textarea id="catatan_review" name="catatan_review" rows="5" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500" placeholder="Tuliskan catatan dan masukan untuk dokumen ini..."></textarea>
            </div>

            <div class="flex justify-end gap-3">
                <button type="button" id="cancelReviewModal" class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 font-medium">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 font-medium">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusFilter = document.getElementById('status-filter');
        const babFilter = document.getElementById('bab-filter');
        const documentItems = document.querySelectorAll('.document-item');

        function applyFilters() {
            const selectedStatus = statusFilter.value;
            const selectedBab = babFilter.value;

            documentItems.forEach(item => {
                const statusMatch = !selectedStatus || item.dataset.status === selectedStatus;
                const babMatch = !selectedBab || item.dataset.bab === selectedBab;

                if (statusMatch && babMatch) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        statusFilter.addEventListener('change', applyFilters);
        babFilter.addEventListener('change', applyFilters);

        // --- Modal Review Functionality ---
        const reviewModal = document.getElementById('reviewModal');
        const openReviewModalButtons = document.querySelectorAll('.open-review-modal');
        const cancelReviewModalButton = document.getElementById('cancelReviewModal');
        const reviewForm = document.getElementById('reviewForm');
        const modalDokumenId = document.getElementById('modal-dokumen-id');

        const catatanReviewTextarea = document.getElementById('catatan_review');
        const fileReviewNameInput = document.getElementById('file_review_name');
        const currentFileReviewSection = document.getElementById('current-file-review-section');
        const currentFileReviewLink = document.getElementById('current-file-review-link');

        openReviewModalButtons.forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const currentStatus = this.dataset.currentStatus;
                const catatanReview = this.dataset.catatanReview;
                const dokumenReviewPath = this.dataset.dokumenReviewPath;

                reviewForm.action = `{{ route('dosen.dokumen.online.update', '') }}/${id}`;

                modalDokumenId.value = id;

                catatanReviewTextarea.value = catatanReview;

                fileReviewNameInput.value = '';
                currentFileReviewLink.href = '#';
                currentFileReviewLink.textContent = '';
                currentFileReviewSection.classList.add('hidden');

                if (dokumenReviewPath) {
                    const fileName = dokumenReviewPath.split('/').pop();
                    currentFileReviewLink.href = `{{ route('dosen.dokumen.online.download.dosen', '') }}/${id}`;
                    currentFileReviewLink.textContent = fileName;
                    currentFileReviewSection.classList.remove('hidden');
                }

                reviewModal.classList.remove('hidden');
            });
        });

        cancelReviewModalButton.addEventListener('click', function() {
            reviewModal.classList.add('hidden');
            reviewForm.reset();
        });

        reviewModal.addEventListener('click', function(event) {
            if (event.target === reviewModal) {
                reviewModal.classList.add('hidden');
                reviewForm.reset();
            }
        });

        document.getElementById('file_review_input').addEventListener('change', function() {
            document.getElementById('file_review_name').value = this.files[0] ? this.files[0].name : 'Tidak ada file dipilih';
        });

        // --- ACC Button Functionality ---
        document.querySelectorAll('.acc-button').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const id = this.dataset.id;
            const actionUrl = this.dataset.action;

            Swal.fire({
                title: 'Konfirmasi ACC Tugas Akhir',
                text:  'Apakah anda yakin ingin ACC tugas akhir mahasiswa ini? Setelah di-ACC, tugas akhir mahasiswa akan DITERIMA, dan mahasiswa harus segera menjadwalkan serta melaksanakan Seminar Hasil. \n \n Keputusan ini bersifat final dan tidak dapat dibatalkan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ACC',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(actionUrl, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({ id: id })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Berhasil!', 'Dokumen telah di-ACC dan ditandai disetujui.', 'success').then(() => {
                                // Remove the document from the DOM
                                const documentItem = button.closest('.document-item');
                                documentItem.remove();
                                // Check if there are no documents left
                                if (document.querySelectorAll('.document-item').length === 0) {
                                    const dokumenList = document.getElementById('dokumen-list');
                                    dokumenList.innerHTML = `
                                        <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center">
                                            <div class="flex justify-center mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada dokumen</h3>
                                            <p class="text-gray-600">Tidak ada dokumen bimbingan yang perlu direview saat ini.</p>
                                        </div>
                                    `;
                                }
                                // Reapply filters to ensure consistency
                                applyFilters();
                            });
                        } else {
                            Swal.fire('Gagal!', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Error!', 'Terjadi kesalahan saat memproses.', 'error');
                    });
                }
            });
        });
    });
    });

// Filter functionality
document.addEventListener('DOMContentLoaded', function() {
    const babFilter = document.getElementById('bab-filter');
    const statusFilter = document.getElementById('status-filter');
    const documentItems = document.querySelectorAll('.document-item');

    function filterDocuments() {
        const selectedBab = babFilter.value.toLowerCase();
        const selectedStatus = statusFilter.value.toLowerCase();

        documentItems.forEach(item => {
            const itemBab = item.dataset.bab.toLowerCase();
            const itemStatus = item.dataset.status.toLowerCase();

            const babMatch = !selectedBab || itemBab === selectedBab;
            const statusMatch = !selectedStatus || itemStatus === selectedStatus;

            if (babMatch && statusMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    babFilter.addEventListener('change', filterDocuments);
    statusFilter.addEventListener('change', filterDocuments);
});
</script>

@endsection
