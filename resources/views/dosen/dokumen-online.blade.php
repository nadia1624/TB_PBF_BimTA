@extends('layouts.dosen')

@section('content')
<div class="container">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-6">Dokumen Bimbingan</h1>

        <!-- Stats Cards - Exactly matching the UI design -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <!-- Total Dokumen Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="mr-6">
                        <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Total Dokumen</p>
                        <p class="text-4xl font-bold">{{ $totalDokumen }}</p>
                    </div>
                </div>
            </div>

            <!-- Perlu Review Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="mr-6">
                        <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Perlu Review</p>
                        <p class="text-4xl font-bold">{{ $perluReview }}</p>
                    </div>
                </div>
            </div>

            <!-- Sudah Direview Card -->
            <div class="bg-white p-6 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <div class="mr-6">
                        <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-600 text-sm">Sudah Direview</p>
                        <p class="text-4xl font-bold">{{ $sudahReview }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters - Matching the UI design -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="w-full md:w-1/2">
                <select id="status-filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="">Semua Status</option>
                    <option value="menunggu">Belum Direview</option>
                    <option value="diproses">Perlu Review</option>
                    <option value="selesai">Disetujui</option>
                </select>
            </div>
            <div class="w-full md:w-1/2">
                <select id="bab-filter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5">
                    <option value="">Semua Bab</option>
                    <option value="bab 1">Bab 1</option>
                    <option value="bab 2">Bab 2</option>
                    <option value="bab 3">Bab 3</option>
                    <option value="bab 4">Bab 4</option>
                    <option value="bab 5">Bab 5</option>
                    <option value="lengkap">Lengkap</option>
                </select>
            </div>
        </div>

<!-- Documents List -->
<div id="dokumen-list">
    @forelse($dokumen as $item)
    <div class="bg-white p-6 rounded-lg shadow-sm mb-4 document-item"
         data-status="{{ $item->status }}"
         data-bab="{{ $item->bab ?? '' }}">

        <!-- Status and Date -->
        <div class="flex justify-between items-center mb-4">
            <div>
                @if($item->status == 'menunggu')
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></span>
                        <span class="text-sm text-yellow-500">Belum Direview</span>
                    </div>
                @elseif($item->status == 'diproses')
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-blue-500 rounded-full mr-2"></span>
                        <span class="text-sm text-blue-500">Perlu Review</span>
                    </div>
                @elseif($item->status == 'selesai')
                    <div class="flex items-center">
                        <span class="w-3 h-3 bg-green-500 rounded-full mr-2"></span>
                        <span class="text-sm text-green-500">Disetujui</span>
                    </div>
                @endif
            </div>

            <div class="flex items-center">
                <svg class="w-4 h-4 text-gray-400 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }} {{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}
                </span>
            </div>
        </div>

        <!-- Student Info -->
        <div class="flex">
            <div class="mr-4">
                @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->mahasiswa)
                    <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center text-white font-bold text-xl">
                        {{ substr($item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'X', 0, 1) }}
                    </div>
                @else
                    <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-xl">
                        ?
                    </div>
                @endif
            </div>
            <div>
                @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->mahasiswa)
                    <h3 class="font-bold text-lg">
                        {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'Nama tidak tersedia' }}
                    </h3>
                    <p class="text-gray-600">
                        {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nim ?? 'NIM tidak tersedia' }}
                    </p>
                    <p class="text-gray-700 mt-1">
                        {{ $item->jadwalBimbingan->pengajuanJudul->judul ?? 'Judul tidak tersedia' }}
                    </p>
                @else
                    <h3 class="font-bold text-lg">Informasi Mahasiswa Tidak Tersedia</h3>
                    <p class="text-gray-600">Data belum lengkap</p>
                @endif
            </div>
        </div>

        <!-- Document Info - Menampilkan info dokumen jika sudah diupload -->
        @if($item->dokumen_mahasiswa)
        <div class="mt-4">
            <!-- Document Label -->
            <div class="flex items-center mb-2">
                <svg class="w-5 h-5 text-gray-500 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm font-medium text-gray-700">{{ ucfirst($item->bab ?? 'Dokumen') }}</span>
            </div>

            <!-- File Link - Updated with direct route to controller method -->
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('dosen.dokumen.online.view', $item->id) }}"
                   class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 group"
                   target="_blank">
                    <div class="mr-3 bg-blue-100 p-2 rounded-md group-hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-blue-600 font-medium block">{{ basename($item->dokumen_mahasiswa) }}</span>
                        <span class="text-xs text-gray-500">Lihat dokumen</span>
                    </div>
                </a>

                <a href="{{ route('dosen.dokumen.online.download', $item->id) }}"
                   class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200 group">
                    <div class="mr-3 bg-green-100 p-2 rounded-md group-hover:bg-green-200 transition-colors duration-200">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <span class="text-green-600 font-medium block">Download</span>
                        <span class="text-xs text-gray-500">Unduh dokumen</span>
                    </div>
                </a>
            </div>
        </div>
        @else
        <!-- Tampilkan pesan jika dokumen belum diupload -->
        <div class="mt-4 p-3 bg-yellow-50 text-yellow-700 rounded-md">
            <p class="text-sm flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Mahasiswa belum mengupload dokumen bimbingan
            </p>
        </div>
        @endif
    </div>
    @empty
    <div class="bg-white p-8 rounded-lg shadow-sm text-center">
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Tidak ada dokumen</h3>
        <p class="mt-1 text-gray-500">Tidak ada dokumen bimbingan yang perlu direview saat ini.</p>
    </div>
    @endforelse
</div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
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

        // Review button functionality
        document.querySelectorAll('.review-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('review-form-' + id);

                if (form) {
                    form.classList.remove('hidden');
                    this.classList.add('hidden');
                }
            });
        });

        // Cancel review button functionality
        document.querySelectorAll('.cancel-review-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const form = document.getElementById('review-form-' + id);
                const reviewBtn = document.querySelector('.review-btn[data-id="' + id + '"]');

                if (form && reviewBtn) {
                    form.classList.add('hidden');
                    reviewBtn.classList.remove('hidden');
                }
            });
        });

        // Preview button functionality
        document.querySelectorAll('.preview-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const details = document.getElementById('review-details-' + id);

                if (details) {
                    details.classList.remove('hidden');
                    this.classList.add('hidden');
                }
            });
        });

        // Hide details button functionality
        document.querySelectorAll('.hide-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const details = document.getElementById('review-details-' + id);
                const previewBtn = document.querySelector('.preview-btn[data-id="' + id + '"]');

                if (details && previewBtn) {
                    details.classList.add('hidden');
                    previewBtn.classList.remove('hidden');
                }
            });
        });
    });
</script>
@endsection
