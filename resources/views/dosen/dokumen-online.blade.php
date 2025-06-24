@extends('layouts.dosen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Dokumen Bimbingan</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <div class="flex items-center">
                <div class="mr-6 p-3 bg-gray-100 rounded-lg">
                    <svg class="w-10 h-10 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Dokumen</p>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $totalDokumen }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <div class="flex items-center">
                <div class="mr-6 p-3 bg-yellow-100 rounded-lg">
                    <svg class="w-10 h-10 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Perlu Review</p>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $perluReview }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200">
            <div class="flex items-center">
                <div class="mr-6 p-3 bg-green-100 rounded-lg">
                    <svg class="w-10 h-10 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Sudah Direview</p>
                    <p class="text-4xl font-extrabold text-gray-900">{{ $sudahReview }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 mb-8">
        <div class="w-full md:w-1/2">
            <label for="status-filter" class="sr-only">Filter Berdasarkan Status</label>
            <select id="status-filter" class="bg-white border border-gray-300 text-gray-800 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm">
                <option value="">Semua Status</option>
                <option value="menunggu">Belum Direview</option>
                <option value="diproses">Perlu Review</option>
                <option value="selesai">Disetujui</option>
            </select>
        </div>
        <div class="w-full md:w-1/2">
            <label for="bab-filter" class="sr-only">Filter Berdasarkan Bab</label>
            <select id="bab-filter" class="bg-white border border-gray-300 text-gray-800 text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 shadow-sm">
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

    <div id="dokumen-list">
        @forelse($dokumen as $item)
        <div class="bg-white p-6 rounded-xl shadow-md border border-gray-200 mb-6 document-item"
             data-status="{{ $item->status }}"
             data-bab="{{ $item->bab ?? '' }}">

            <div class="flex justify-between items-center mb-4">
                <div>
                    @if($item->status == 'menunggu')
                        <div class="flex items-center text-yellow-600">
                            <span class="w-2.5 h-2.5 bg-yellow-500 rounded-full mr-2"></span>
                            <span class="text-sm font-semibold">Belum Direview</span>
                        </div>
                    @elseif($item->status == 'diproses')
                        <div class="flex items-center text-blue-600">
                            <span class="w-2.5 h-2.5 bg-blue-500 rounded-full mr-2"></span>
                            <span class="text-sm font-semibold">Perlu Review</span>
                        </div>
                    @elseif($item->status == 'selesai')
                        <div class="flex items-center text-green-600">
                            <span class="w-2.5 h-2.5 bg-green-500 rounded-full mr-2"></span>
                            <span class="text-sm font-semibold">Sudah Direview</span>
                        </div>
                    @endif
                </div>

                <div class="flex items-center text-gray-500 text-sm">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                    </svg>
                    <span>
                        {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                        <span class="ml-1">{{ \Carbon\Carbon::parse($item->created_at)->format('H:i') }}</span>
                    </span>
                </div>
            </div>

            <div class="flex items-start mb-4">
                <div class="mr-4 mt-1">
                    @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->mahasiswa)
                        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl flex-shrink-0">
                            {{ substr($item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'X', 0, 1) }}
                        </div>
                    @else
                        <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold text-xl flex-shrink-0">
                            ?
                        </div>
                    @endif
                </div>
                <div class="flex-grow">
                    @if($item->jadwalBimbingan && $item->jadwalBimbingan->pengajuanJudul && $item->jadwalBimbingan->pengajuanJudul->mahasiswa)
                        <h3 class="font-bold text-gray-800 text-lg">
                            {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama_lengkap ?? $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nama ?? 'Nama tidak tersedia' }}
                        </h3>
                        <p class="text-gray-600 text-sm">
                            {{ $item->jadwalBimbingan->pengajuanJudul->mahasiswa->nim ?? 'NIM tidak tersedia' }}
                        </p>
                        <p class="text-gray-700 font-medium mt-2">
                            {{ $item->jadwalBimbingan->pengajuanJudul->judul ?? 'Judul tidak tersedia' }}
                        </p>
                    @else
                        <h3 class="font-bold text-gray-800 text-lg">Informasi Mahasiswa Tidak Tersedia</h3>
                        <p class="text-gray-600 text-sm">Data belum lengkap</p>
                    @endif
                </div>
            </div>

            @if($item->dokumen_mahasiswa)
            <div class="mt-4 border-t pt-4">
                <div class="flex items-center mb-3 text-gray-700">
                    <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-semibold">{{ ucfirst($item->bab ?? 'Dokumen') }}</span>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('dosen.dokumen.online.view', $item->id) }}"
                       class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 group flex-shrink-0"
                       target="_blank">
                        <div class="mr-3 bg-blue-100 p-2 rounded-md group-hover:bg-blue-200 transition-colors duration-200">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-blue-600 font-medium block">
                                {{ basename($item->dokumen_mahasiswa ?? 'Dokumen') }}
                            </span>
                            <span class="text-xs text-gray-500">Lihat dokumen</span>
                        </div>
                    </a>

                    <a href="{{ route('dosen.dokumen.online.download', $item->id) }}"
                       class="flex items-center p-3 bg-gray-100 hover:bg-gray-200 rounded-lg transition-colors duration-200 group flex-shrink-0">
                        <div class="mr-3 bg-gray-200 p-2 rounded-md group-hover:bg-gray-300 transition-colors duration-200">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="text-gray-700 font-medium block">Download</span>
                            <span class="text-xs text-gray-500">Unduh dokumen</span>
                        </div>
                    </a>

                    <button class="flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-md transition-colors duration-200 open-review-modal flex-shrink-0"
                            data-id="{{ $item->id }}"
                            data-current-status="{{ $item->status }}"
                            data-catatan-review="{{ $item->keterangan_dosen ?? '' }}"
                            data-dokumen-review-path="{{ $item->dokumen_dosen ?? '' }}">
                        Review
                    </button>

                    @if($item->dokumen_mahasiswa && $item->bab === 'lengkap')
                    <button class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium acc-button"
                            data-id="{{ $item->id }}"
                            data-action="{{ route('dosen.dokumen.online.acc', $item->id) }}">
                        ACC
                    </button>
                    @endif
                </div>

                @if($item->keterangan_dosen || $item->dokumen_dosen)
                <div class="mt-6 p-4 bg-gray-100 rounded-lg border border-gray-200">
                    <h4 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h10M7 16h10M9 3h6a2 2 0 012 2v14a2 2 0 01-2 2H9a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                        Balasan Review Dosen
                    </h4>
                    <p class="text-gray-700 text-sm leading-relaxed mb-2">
                        {{ $item->keterangan_dosen ?? 'Dosen belum memberikan catatan review.' }}
                    </p>
                    @if($item->dokumen_dosen)
                        <a href="{{ route('dosen.dokumen.online.download.dosen', $item->id) }}" class="text-blue-600 text-sm font-medium hover:underline inline-flex items-center mt-2">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Unduh File Review Dosen
                        </a>
                    @endif
                    <p class="text-xs text-gray-500 mt-2">Review Pada: {{ \Carbon\Carbon::parse($item->tanggal_review)->format('d F Y, H:i') }}</p>
                </div>
                @endif
            </div>
            @else
            <div class="mt-4 p-5 bg-yellow-50 text-yellow-700 rounded-lg border border-yellow-200">
                <p class="text-base flex items-center font-medium">
                    <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Mahasiswa belum mengupload dokumen bimbingan untuk sesi ini.
                </p>
            </div>
            @endif
        </div>
        @empty
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-200 text-center">
            <div class="flex justify-center mb-4">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900">Tidak ada dokumen</h3>
            <p class="mt-2 text-gray-600">Tidak ada dokumen bimbingan yang perlu direview saat ini.</p>
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
                    title: 'Konfirmasi ACC Tugak Akhir',
                    text: 'Apakah anda yakin ingin ACC tugas akhir mahasiswa ini? Setelah di-ACC, status akan berubah menjadi selesai dan tidak dapat diubah lagi.',
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
                                Swal.fire('Berhasil!', 'Dokumen telah di-ACC dan ditandai selesai.', 'success').then(() => {
                                    location.reload();
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
</script>
@endsection
