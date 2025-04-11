@extends('layouts.dosen')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Pengajuan Judul</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-3 gap-4 mb-6">
        <!-- Total Pengajuan Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div class="p-2">
                    <svg class="w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-gray-700 text-sm">Total Pengajuan</p>
                    <p class="text-3xl font-bold">{{ $totalPengajuan }}</p>
                </div>
            </div>
        </div>

        <!-- Menunggu Verifikasi Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div class="p-2">
                    <svg class="w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-gray-700 text-sm">Menunggu Verifikasi</p>
                    <p class="text-3xl font-bold">{{ $menungguVerifikasi }}</p>
                </div>
            </div>
        </div>

        <!-- Disetujui Card -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div class="p-2">
                    <svg class="w-8 h-8 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div class="text-center">
                    <p class="text-gray-700 text-sm">Disetujui</p>
                    <p class="text-3xl font-bold">{{ $disetujui }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter dropdown -->
    <div class="flex justify-end mb-4">
        <select id="statusFilter" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5">
            <option value="all">Semua Status</option>
            <option value="diproses">Menunggu Verifikasi</option>
            <option value="diterima">Disetujui</option>
            <option value="ditolak">Ditolak</option>
        </select>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer" class="hidden border-l-4 p-4 mb-4" role="alert">
        <p id="alertMessage"></p>
    </div>

    <!-- Pengajuan Card -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6">
            @if($pengajuan)
            <div class="flex items-center mb-4">
                <div class="mr-4">
                    @if($pengajuan->mahasiswa->gambar)
                    <div class="w-12 h-12 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $pengajuan->mahasiswa->gambar) }}" alt="Foto {{ $pengajuan->mahasiswa->nama_lengkap }}" class="w-full h-full object-cover">
                    </div>
                    @else
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    @endif
                </div>
                <div>
                    <h3 class="text-lg font-medium">{{ $pengajuan->mahasiswa->nama_lengkap }}</h3>
                    <p class="text-gray-600 text-sm">{{ $pengajuan->mahasiswa->nim }}</p>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="font-medium mb-1">Judul TA:</h4>
                <p>{{ $pengajuan->judul }}</p>
            </div>

            <div class="mb-4">
                <h4 class="font-medium mb-1">Deskripsi:</h4>
                <p>{{ $pengajuan->deskripsi }}</p>
            </div>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <button id="rejectButton" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                    Tolak Judul
                </button>
                <button id="approveButton" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded">
                    Setujui Judul
                </button>
            </div>
            @else
            <p class="text-center text-gray-600">Tidak ada pengajuan judul yang tersedia</p>
            @endif
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md mx-4">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold">Setujui Pengajuan Judul</h3>
        </div>
        <form id="approveForm" class="p-4">
            <div class="mb-4">
                <label for="approveComment" class="block text-sm font-medium text-gray-700 mb-1">Berikan Komentar</label>
                <textarea id="approveComment" class="w-full border rounded p-2" rows="3" placeholder="Masukkan komentar (opsional)"></textarea>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" id="cancelApprove" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded">
                    Setujui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-md mx-4">
        <div class="p-4 border-b">
            <h3 class="text-lg font-semibold">Tolak Pengajuan Judul</h3>
        </div>
        <form id="rejectForm" class="p-4">
            <div class="mb-4">
                <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-1">Berikan Alasan</label>
                <textarea id="rejectReason" class="w-full border rounded p-2" rows="3" placeholder="Masukkan alasan penolakan" required></textarea>
            </div>
            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" id="cancelReject" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded">
                    Tolak
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const approveButton = document.getElementById('approveButton');
    const rejectButton = document.getElementById('rejectButton');
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    const cancelApprove = document.getElementById('cancelApprove');
    const cancelReject = document.getElementById('cancelReject');
    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Show approve modal
    if (approveButton) {
        approveButton.addEventListener('click', function() {
            approveModal.classList.remove('hidden');
            approveModal.classList.add('flex');
        });
    }

    // Show reject modal
    if (rejectButton) {
        rejectButton.addEventListener('click', function() {
            rejectModal.classList.remove('hidden');
            rejectModal.classList.add('flex');
        });
    }

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

    // Handle approve form submission
    if (approveForm) {
        approveForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const comment = document.getElementById('approveComment').value;
            updateStatus('diterima', comment);
        });
    }

    // Handle reject form submission
    if (rejectForm) {
        rejectForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const reason = document.getElementById('rejectReason').value;
            if (!reason.trim()) {
                alert('Alasan penolakan harus diisi');
                return;
            }

            updateStatus('ditolak', reason);
        });
    }

    // Function to update status
    // Function to update status
function updateStatus(status, komentar = '') {
    // Show loading overlay
    loadingOverlay.classList.remove('hidden');
    loadingOverlay.classList.add('flex');

    // Create form data
    const formData = new FormData();
    formData.append('status', status);
    formData.append('komentar', komentar);
    formData.append('_method', 'PUT');
    formData.append('_token', '{{ csrf_token() }}');  // Pastikan token CSRF ada di formData

    // Send request
    fetch('{{ route("dosen.pengajuan.status", $pengajuan->id ?? 0) }}', {
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
        // Hide loading overlay
        loadingOverlay.classList.add('hidden');
        loadingOverlay.classList.remove('flex');

        // Hide modals
        approveModal.classList.add('hidden');
        approveModal.classList.remove('flex');
        rejectModal.classList.add('hidden');
        rejectModal.classList.remove('flex');

        if (data.success) {
            // Show success message
            showAlert('success', data.message || 'Status berhasil diperbarui');
            // Reload page after a delay
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            // Show error message
            showAlert('error', data.message || 'Terjadi kesalahan');
        }
    })
    .catch(error => {
        console.error('Error:', error);

        // Hide loading overlay
        loadingOverlay.classList.add('hidden');
        loadingOverlay.classList.remove('flex');

        // Show error message
        showAlert('error', 'Terjadi kesalahan pada server: ' + error.message);
    });
}

    // Show success/error messages
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

    if (type === 'success') {
        alertContainer.classList.add('bg-green-100', 'border-green-500', 'text-green-700');
    } else {
        alertContainer.classList.add('bg-red-100', 'border-red-500', 'text-red-700');
    }

    alertMessage.textContent = message;
    alertContainer.classList.remove('hidden');

    // Auto-hide alert after 5 seconds
    setTimeout(() => {
        alertContainer.classList.add('hidden');
    }, 5000);
}
</script>
@endpush
@endsection
