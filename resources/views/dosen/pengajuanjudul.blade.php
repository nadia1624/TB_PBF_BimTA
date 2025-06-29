@extends('layouts.dosen')

@section('title', 'Pengajuan Judul')

@section('content')
<div class="container-fluid px-4 py-6 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 animate-fade-in">Pengajuan Judul</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Pengajuan Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-green-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Total Pengajuan</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $totalPengajuan ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Judul yang diajukan</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Review Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-orange-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-orange-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Menunggu Review</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $menungguVerifikasi ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Pengajuan menunggu persetujuan</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disetujui Card -->
        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center justify-between">
                <div class="flex-1">
                    <div class="flex items-center mb-2">
                        <div class="p-2 bg-blue-50 rounded-lg mr-3">
                            <svg class="w-6 h-6 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <h4 class="text-sm font-medium text-gray-600">Disetujui</h4>
                    </div>
                    <p class="text-3xl font-bold text-gray-900 mb-1">{{ $disetujui ?? 0 }}</p>
                    <p class="text-xs text-gray-500">Pengajuan yang disetujui</p>
                </div>
                <div class="ml-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dropdown -->
    <div class="flex justify-end mb-4">
        <select id="statusFilter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
            <option value="all">Semua Status</option>
            <option value="diproses">Menunggu Review</option>
            <option value="diterima">Disetujui</option>
            <option value="ditolak">Ditolak</option>
            <option value="dibatalkan">Dibatalkan</option>
        </select>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer" class="hidden border-l-4 p-4 mb-4" role="alert">
        <p id="alertMessage"></p>
    </div>

    <!-- Daftar Pengajuan Cards -->
    <div class="space-y-4 mb-8">
        @if(isset($pengajuanList) && count($pengajuanList) > 0)
            @foreach($pengajuanList as $item)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow duration-300" data-pengajuan-id="{{ $item->id }}">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <div class="mr-4">
                                @if($item->mahasiswa->gambar)
                                <div class="w-12 h-12 rounded-full overflow-hidden">
                                    <img src="{{ asset('storage/' . $item->mahasiswa->gambar) }}" alt="Foto {{ $item->mahasiswa->nama_lengkap }}" class="w-full h-full object-cover">
                                </div>
                                @else
                                <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-medium text-gray-800">{{ $item->mahasiswa->nama_lengkap }}</h3>
                                <p class="text-gray-600 text-sm">{{ $item->mahasiswa->nim }}</p>
                                <p class="text-sm text-gray-700 mt-1">
                                    Diajukan sebagai:
                                    <span class="font-semibold capitalize">
                                        {{ $item->detailDosen[0]->pembimbing }}
                                    </span>
                                </p>
                            </div>

                            <!-- Status Badge -->
                            <div class="ml-auto">
                                @if($item->detailDosen[0]->status == 'diproses')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-yellow-400"></span>
                                    Menunggu Review
                                </span>
                                @elseif($item->detailDosen[0]->status == 'diterima')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-400"></span>
                                    Disetujui
                                </span>
                                @elseif($item->detailDosen[0]->status == 'ditolak')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-400"></span>
                                    Ditolak
                                </span>
                                @elseif($item->detailDosen[0]->status == 'dibatalkan')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-gray-400"></span>
                                    Dibatalkan
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Timestamp -->
                        <div class="text-right text-sm text-gray-500 mb-4">
                            <span>{{ $item->created_at->format('d F Y') }} • {{ $item->created_at->format('H:i') }}</span>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-medium mb-1 text-gray-800">Judul Tugas Akhir:</h4>
                            <p class="text-gray-600">{{ $item->judul }}</p>
                        </div>

                        <div class="mb-4">
                            <h4 class="font-medium mb-1 text-gray-800">Deskripsi:</h4>
                            <p class="text-gray-600">{{ $item->deskripsi }}</p>
                        </div>

                        @if($item->detailDosen[0]->status == 'diproses')
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <button class="rejectButton bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded" data-id="{{ $item->id }}">
                                Tolak Judul
                            </button>
                            <button class="approveButton bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded" data-id="{{ $item->id }}">
                                Setujui Judul
                            </button>
                        </div>
                        @elseif($item->detailDosen[0]->status == 'diterima')
                        <div class="flex justify-end mt-6">
                            <button class="cancelButton bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded" data-id="{{ $item->id }}">
                                Batalkan Mahasiswa
                            </button>
                        </div>
                        @elseif($item->detailDosen[0]->status == 'dibatalkan')
                        <div class="mt-6">
                            <p class="text-gray-600"><strong>Alasan Pembatalan:</strong> {{ $item->detailDosen[0]->alasan_dibatalkan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-gray-500 mt-4">Tidak ada pengajuan judul yang tersedia</p>
            </div>
        @endif
    </div>

    <!-- Approve Modal -->
    <div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-md mx-4">
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Setujui Pengajuan Judul</h3>
            </div>
            <form id="approveForm" class="p-4">
                <input type="hidden" id="approvePengajuanId" value="">
                <div class="mb-4">
                    <label for="approveComment" class="block text-sm font-medium text-gray-700 mb-1">Berikan Komentar</label>
                    <textarea id="approveComment" class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Masukkan komentar (opsional)"></textarea>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="cancelApprove" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg">
                        Setujui
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-md mx-4">
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Tolak Pengajuan Judul</h3>
            </div>
            <form id="rejectForm" class="p-4">
                <input type="hidden" id="rejectPengajuanId" value="">
                <div class="mb-4">
                    <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-1">Berikan Alasan</label>
                    <textarea id="rejectReason" class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="cancelReject" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
                        Tolak
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Cancel Modal -->
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl w-full max-w-md mx-4">
            <div class="p-4 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Batalkan Mahasiswa</h3>
            </div>
            <form id="cancelForm" class="p-4">
                <input type="hidden" id="cancelPengajuanId" value="">
                <div class="mb-4">
                    <label for="cancelReason" class="block text-sm font-medium text-gray-700 mb-1">Berikan Alasan Pembatalan</label>
                    <textarea id="cancelReason" class="w-full border rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500" rows="3" placeholder="Masukkan alasan pembatalan" required></textarea>
                </div>
                <div class="flex justify-end space-x-2 mt-4">
                    <button type="button" id="cancelCancelModal" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg">
                        Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white p-5 rounded-lg flex items-center">
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span>Memproses...</span>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const approveButtons = document.querySelectorAll('.approveButton');
    const rejectButtons = document.querySelectorAll('.rejectButton');
    const cancelButtons = document.querySelectorAll('.cancelButton');
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    const cancelModal = document.getElementById('cancelModal');
    const cancelApprove = document.getElementById('cancelApprove');
    const cancelReject = document.getElementById('cancelReject');
    const cancelCancelModal = document.getElementById('cancelCancelModal');
    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');
    const cancelForm = document.getElementById('cancelForm');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const approvePengajuanId = document.getElementById('approvePengajuanId');
    const rejectPengajuanId = document.getElementById('rejectPengajuanId');
    const cancelPengajuanId = document.getElementById('cancelPengajuanId');

    // Show approve modal
    approveButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pengajuanId = this.getAttribute('data-id');
            approvePengajuanId.value = pengajuanId;
            approveModal.classList.remove('hidden');
            approveModal.classList.add('flex');
        });
    });

    // Show reject modal
    rejectButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pengajuanId = this.getAttribute('data-id');
            rejectPengajuanId.value = pengajuanId;
            rejectModal.classList.remove('hidden');
            rejectModal.classList.add('flex');
        });
    });

    // Show cancel modal
    cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pengajuanId = this.getAttribute('data-id');
            cancelPengajuanId.value = pengajuanId;
            cancelModal.classList.remove('hidden');
            cancelModal.classList.add('flex');
        });
    });

    // Hide approve modal
    if (cancelApprove) {
        cancelApprove.addEventListener('click', function() {
            approveModal.classList.add('hidden');
            approveModal.classList.remove('flex');
        });
    }

    // Hide reject modal
    if (cancelReject) {
        cancelReject.addEventListener('click', function() {
            rejectModal.classList.add('hidden');
            rejectModal.classList.remove('flex');
        });
    }

    // Hide cancel modal
    if (cancelCancelModal) {
        cancelCancelModal.addEventListener('click', function() {
            cancelModal.classList.add('hidden');
            cancelModal.classList.remove('flex');
        });
    }

    // Handle approve form submission
    if (approveForm) {
        approveForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const pengajuanId = approvePengajuanId.value;
            const comment = document.getElementById('approveComment').value;
            updateStatus(pengajuanId, 'diterima', comment);
        });
    }

    // Handle reject form submission
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const pengajuanId = rejectPengajuanId.value;
            const reason = document.getElementById('rejectReason').value;

            if (!reason.trim()) {
                alert('Alasan penolakan harus diisi');
                return;
            }

            updateStatus(pengajuanId, 'ditolak', reason);
        });
    }

    // Handle cancel form submission
    if (cancelForm) {
    cancelForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const pengajuanId = cancelPengajuanId.value;
        const reason = document.getElementById('cancelReason').value;

        if (!reason.trim()) {
            alert('Alasan pembatalan harus diisi');
            return;
        }

        updateStatus(pengajuanId, 'dibatalkan', reason); // Ubah dari 'ditolak' ke 'dibatalkan'
    });
}

    // Function to update status
    function updateStatus(id, status, komentar = '') {
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        const formData = new FormData();
        formData.append('status', status);
        formData.append('komentar', komentar);
        formData.append('_method', 'PUT');
        formData.append('_token', '{{ csrf_token() }}');

        const url = `/dosen/pengajuanjudul/${id}/status`;

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');

            approveModal.classList.add('hidden');
            approveModal.classList.remove('flex');
            rejectModal.classList.add('hidden');
            rejectModal.classList.remove('flex');
            cancelModal.classList.add('hidden');
            cancelModal.classList.remove('flex');

            if (data.success) {
                showAlert('success', data.message || 'Status berhasil diperbarui');

                const pengajuanId = id;
                const cardElement = document.querySelector(`[data-pengajuan-id="${pengajuanId}"]`);

                if (cardElement) {
                    cardElement.style.display = 'block';

                    const badgeContainer = cardElement.querySelector('.ml-auto');
                    if (badgeContainer) {
                        if (status === 'diterima') {
                            badgeContainer.innerHTML = `
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-green-400"></span>
                                    Disetujui
                                </span>
                            `;

                            const actionContainer = cardElement.querySelector('.grid.grid-cols-2.gap-4.mt-6');
                            if (actionContainer) {
                                actionContainer.outerHTML = `
                                    <div class="flex justify-end mt-6">
                                        <button class="cancelButton bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded" data-id="${pengajuanId}">
                                            Batalkan Mahasiswa
                                        </button>
                                    </div>
                                `;

                                const newCancelButton = cardElement.querySelector('.cancelButton');
                                if (newCancelButton) {
                                    newCancelButton.addEventListener('click', function() {
                                        cancelPengajuanId.value = this.getAttribute('data-id');
                                        cancelModal.classList.remove('hidden');
                                        cancelModal.classList.add('flex');
                                    });
                                }
                            }
                        } else if (status === 'ditolak') {
                            badgeContainer.innerHTML = `
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-red-400"></span>
                                    Ditolak
                                </span>
                            `;

                            const actionContainer = cardElement.querySelector('.grid.grid-cols-2.gap-4.mt-6');
                            if (actionContainer) {
                                actionContainer.remove();
                            }
                        } else if (status === 'dibatalkan') {
                            badgeContainer.innerHTML = `
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <span class="mr-1 h-2 w-2 rounded-full bg-gray-400"></span>
                                    Dibatalkan
                                </span>
                            `;

                            const actionContainer = cardElement.querySelector('.flex.justify-end.mt-6');
                            if (actionContainer) {
                                actionContainer.remove();
                            }

                            const alasanContainer = cardElement.querySelector('.mt-6');
                            if (alasanContainer) {
                                alasanContainer.innerHTML = `
                                    <p><strong>Alasan Pembatalan:</strong> ${komentar}</p>
                                `;
                            }
                        }
                    }

                    setTimeout(() => {
                        const statusFilter = document.getElementById('statusFilter');
                        if (statusFilter) {
                            filterCards(statusFilter.value);
                        }
                    }, 100);
                }
            } else {
                showAlert('error', data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');
            showAlert('error', 'Terjadi kesalahan pada server: ' + error.message);
        });
    }

    const statusFilter = document.getElementById('statusFilter');
    if (statusFilter) {
        statusFilter.value = '{{ $statusFilter ?? "all" }}';
        filterCards(statusFilter.value);

        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value;
            filterCards(selectedStatus);

            const url = new URL(window.location);
            url.searchParams.set('status', selectedStatus);
            history.pushState({}, '', url);
        });
    }

    function filterCards(selectedStatus) {
        const cards = document.querySelectorAll('[data-pengajuan-id]');
        cards.forEach(card => {
            card.style.display = 'block';
            if (selectedStatus !== 'all') {
                const statusBadge = card.querySelector('.ml-auto span');
                let cardStatus = '';
                if (statusBadge) {
                    const badgeText = statusBadge.textContent.trim();
                    if (badgeText.includes('Menunggu Review')) cardStatus = 'diproses';
                    else if (badgeText.includes('Disetujui')) cardStatus = 'diterima';
                    else if (badgeText.includes('Ditolak')) cardStatus = 'ditolak';
                    else if (badgeText.includes('Dibatalkan')) cardStatus = 'dibatalkan';
                    if (cardStatus !== selectedStatus) card.style.display = 'none';
                }
            }
        });
    }

    @if(session('success'))
        showAlert('success', "{{ session('success') }}");
    @endif

    @if(session('error'))
        showAlert('error', "{{ session('error') }}");
    @endif
});

// Show alert message
function showAlert(type, message) {
    const alertContainer = document.getElementById('alertContainer');
    const alertMessage = document.getElementById('alertMessage');
    alertContainer.classList.remove('hidden', 'bg-green-100', 'border-green-500', 'text-green-700', 'bg-red-100', 'border-red-500', 'text-red-700');
    if (type === 'success') alertContainer.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
    else alertContainer.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
    alertMessage.textContent = message;
    alertContainer.classList.remove('hidden');
    setTimeout(() => alertContainer.classList.add('hidden'), 5000);
}
</script>

<style>
    .animate-fade-in {
        opacity: 0;
    }

    /* Smooth gradient animations */
    .bg-gradient-to-br:hover {
        background-size: 200% 200%;
        animation: gradient-shift 3s ease infinite;
    }

    @keyframes gradient-shift {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Enhanced card hover effects */
    .bg-white:hover {
        transform: translateY(-2px);
    }

    /* Custom scrollbar for better aesthetics */
    .space-y-4::-webkit-scrollbar {
        width: 4px;
    }

    .space-y-4::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .space-y-4::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 10px;
    }

    .space-y-4::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
</style>

@endpush
@endsection
