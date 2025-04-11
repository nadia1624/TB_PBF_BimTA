@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header with title and status button -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center">
            <a href="{{ route('admin.pengajuanta') }}" class="mr-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </a>
            <h2 class="text-xl font-semibold">Detail Pengajuan TA</h2>
        </div>

        <div>
            @php
                $status = 'diproses';
                $statusLabel = 'Diproses';
                $statusClass = 'bg-yellow-300';

                // Get status from detail_dosen
                if($pengajuan->detailDosen->isNotEmpty()) {
                    $detailDosen = $pengajuan->detailDosen->first();
                    $status = $detailDosen->status;

                    if($status == 'diterima') {
                        $statusLabel = 'Diterima';
                        $statusClass = 'bg-green-500 text-white';
                    } elseif($status == 'ditolak') {
                        $statusLabel = 'Ditolak';
                        $statusClass = 'bg-red-500 text-white';
                    }
                }
            @endphp
            <button class="{{ $statusClass }} px-4 py-2 rounded-full font-medium">
                {{ $statusLabel }}
            </button>
        </div>
    </div>

    <!-- Main content -->
    <div class="grid grid-cols-1 gap-6">
        <!-- Upper cards: Student and Supervisor info -->
        <div class="grid md:grid-cols-2 gap-6">
            <!-- Student info card -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex">
                    <div class="mr-4">
                        @if($pengajuan->mahasiswa->gambar)
                        <div class="w-16 h-16 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $pengajuan->mahasiswa->gambar) }}" alt="Foto {{ $pengajuan->mahasiswa->nama_lengkap }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <svg class="w-10 h-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1">Mahasiswa</h3>
                        <p class="text-xl font-medium">{{ $pengajuan->mahasiswa->nama_lengkap }}</p>
                        <p class="text-gray-600">NIM {{ $pengajuan->mahasiswa->nim }}</p>
                    </div>
                </div>
            </div>

            <!-- Supervisor info card -->
            <div class="bg-white p-6 rounded-lg shadow">
                <div class="flex">
                    <div class="mr-4">
                        @if($dosenPembimbing && $dosenPembimbing->gambar)
                        <div class="w-16 h-16 rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $dosenPembimbing->gambar) }}" alt="Foto {{ $dosenPembimbing->nama_lengkap }}" class="w-full h-full object-cover">
                        </div>
                        @else
                        <div class="bg-gray-100 p-3 rounded-lg">
                            <svg class="w-10 h-10 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        @endif
                    </div>
                    <div>
                        <h3 class="text-lg font-bold mb-1">Dosen Pembimbing</h3>
                        @if($dosenPembimbing)
                        <p class="text-xl font-medium">{{ $dosenPembimbing->nama_lengkap }}</p>
                        <p class="text-gray-600">NIP {{ $dosenPembimbing->nip }}</p>
                        @else
                        <p class="text-yellow-600 font-medium">Belum ditentukan</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Thesis info card -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex">
                <div class="mr-4">
                    <div class="bg-gray-100 p-3 rounded-lg">
                        <svg class="w-12 h-12 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-xl font-bold mb-4">Tugas Akhir</h3>

                    <div class="mb-3">
                        <p class="font-bold">Judul</p>
                        <p class="text-gray-800">{{ $pengajuan->judul }}</p>
                    </div>

                    @if($pengajuan->deskripsi)
                    <div class="mb-3">
                        <p class="font-bold">Deskripsi</p>
                        <p class="text-gray-800">{{ $pengajuan->deskripsi }}</p>
                    </div>
                    @endif

                    <div class="mb-3">
                        <p class="font-bold">Tanggal Pengajuan</p>
                        <p class="text-gray-800">{{ \Carbon\Carbon::parse($pengajuan->created_at)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white rounded-lg p-6 w-full max-w-md">
        <h3 class="text-lg font-bold mb-4">Alasan Penolakan</h3>
        <form id="rejectionForm">
            <textarea id="rejectionReason" class="w-full border rounded p-2 mb-4" rows="4" placeholder="Masukkan alasan penolakan" required></textarea>
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelReject" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Konfirmasi Tolak
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
    const rejectButton = document.getElementById('rejectButton');
    const rejectionModal = document.getElementById('rejectionModal');
    const cancelReject = document.getElementById('cancelReject');
    const rejectionForm = document.getElementById('rejectionForm');
    const approveButton = document.getElementById('approveButton');
    const loadingOverlay = document.getElementById('loadingOverlay');

    // Show rejection modal
    if (rejectButton) {
        rejectButton.addEventListener('click', function() {
            rejectionModal.classList.remove('hidden');
            rejectionModal.classList.add('flex');
        });
    }

    // Hide rejection modal
    if (cancelReject) {
        cancelReject.addEventListener('click', function() {
            rejectionModal.classList.add('hidden');
            rejectionModal.classList.remove('flex');
        });
    }

    // Handle rejection form submission
    if (rejectionForm) {
        rejectionForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const reason = document.getElementById('rejectionReason').value;
            if (!reason.trim()) {
                alert('Alasan penolakan harus diisi');
                return;
            }

            updateStatus('ditolak', reason);
        });
    }

    // Handle approval
    if (approveButton) {
        approveButton.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin menyetujui pengajuan ini?')) {
                updateStatus('diterima');
            }
        });
    }

    // Function to update status
    function updateStatus(status, reason = '') {
        // Show loading overlay
        loadingOverlay.classList.remove('hidden');
        loadingOverlay.classList.add('flex');

        // Create form data
        const formData = new FormData();
        formData.append('status', status);
        if (reason) {
            formData.append('reason', reason);
        }
        formData.append('_method', 'PUT');

        // Send request
        fetch('{{ route("admin.pengajuanta.status", $pengajuan->id) }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            // Hide loading overlay
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');

            // Hide modal if open
            rejectionModal.classList.add('hidden');
            rejectionModal.classList.remove('flex');

            if (data.success) {
                // Show success message
                alert(data.message || 'Status berhasil diperbarui');
                // Reload page
                window.location.reload();
            } else {
                // Show error message
                alert(data.message || 'Terjadi kesalahan');
            }
        })
        .catch(error => {
            console.error('Error:', error);

            // Hide loading overlay
            loadingOverlay.classList.add('hidden');
            loadingOverlay.classList.remove('flex');

            // Show error message
            alert('Terjadi kesalahan pada server');
        });
    }
});
</script>
@endpush
@endsection
