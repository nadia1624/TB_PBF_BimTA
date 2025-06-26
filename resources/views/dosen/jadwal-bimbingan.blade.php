@extends('layouts.dosen')

@section('content')
<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-6">Jadwal Bimbingan</h1>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <!-- Bimbingan Hari Ini Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Bimbingan hari ini</p>
                    <h3 class="text-4xl font-bold">{{ $todaySchedulesCount }}</h3>
                </div>
            </div>
        </div>

        <!-- Menunggu Konfirmasi Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Menunggu Konfirmasi</p>
                    <h3 class="text-4xl font-bold">{{ $pendingSchedulesCount }}</h3>
                </div>
            </div>
        </div>

        <!-- Total Selesai Card -->
        <div class="bg-white p-6 rounded-lg shadow-md">
            <div class="flex items-center">
                <div class="mr-4">
                    <svg class="w-12 h-12 text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Total Selesai</p>
                    <h3 class="text-4xl font-bold">{{ $completedSchedulesCount }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini Section -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <div class="flex items-center mb-4">
            <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h2 class="text-xl font-bold">Jadwal Hari Ini</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($jadwalHariIni as $jadwal)
            <div class="border rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                        <svg class="w-8 h-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ $jadwal->pengajuanJudul->mahasiswa->nama }}</h3>
                        <p class="text-sm text-gray-600">{{ $jadwal->pengajuanJudul->mahasiswa->nim }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-2">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d F Y') }}</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($jadwal->waktu_pengajuan)->format('H:i') }} WIB</span>
                    </div>

                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                        <span>{{ $jadwal->metode == 'online' ? 'Online' : 'Tatap Muka' }}</span>
                    </div>

                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 text-gray-600 mt-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Keterangan: {{ $jadwal->keterangan ?? 'Tidak ada keterangan' }}</span>
                    </div>

                    <div class="flex items-center mt-2">
                        <a href="{{ route('dosen.dokumen.online') }}" class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-2">
                <p class="text-gray-500 text-center py-4">Tidak ada jadwal bimbingan untuk hari ini</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Jadwal Mendatang Section -->
    <div class="bg-white p-6 rounded-lg shadow-md">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center">
                <svg class="w-6 h-6 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <h2 class="text-xl font-bold">Jadwal Mendatang</h2>
            </div>

            <div class="relative">
                <input type="text" id="search" placeholder="Cari jadwal..." class="pl-10 pr-4 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                <svg class="w-5 h-5 text-gray-500 absolute left-3 top-2.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-3 px-4 text-left">MAHASISWA</th>
                        <th class="py-3 px-4 text-left">JUDUL</th>
                        <th class="py-3 px-4 text-left">METODE</th>
                        <th class="py-3 px-4 text-left">JADWAL</th>
                        <th class="py-3 px-4 text-left">STATUS</th>
                        <th class="py-3 px-4 text-left">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwalMendatang as $jadwal)
                    <tr class="border-t hover:bg-gray-50" data-id="{{ $jadwal->id }}" data-metode="{{ $jadwal->metode }}">
                        <td class="py-3 px-4">{{ $jadwal->pengajuanJudul->mahasiswa->nama_lengkap }}</td>
                        <td class="py-3 px-4">{{ $jadwal->pengajuanJudul->judul }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 rounded-full text-xs {{ $jadwal->metode == 'online' ? 'bg-blue-100 text-blue-800' : ($jadwal->metode == 'offline' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $jadwal->metode == 'online' ? 'Online Meeting' : ($jadwal->metode == 'offline' ? 'Offline Meeting' : '-') }}
                            </span>
                        </td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($jadwal->tanggal_pengajuan)->format('d/m/Y') }}</td>
                        <td class="py-3 px-4">
                            @if($jadwal->status == 'diproses')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Menunggu</span>
                            @elseif($jadwal->status == 'diterima')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Disetujui</span>
                            @elseif($jadwal->status == 'ditolak')
                                <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Ditolak</span>
                            @elseif($jadwal->status == 'selesai')
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Selesai</span>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex space-x-2">
                                @if($jadwal->status == 'diproses')
                                <button type="button" class="approve-btn bg-green-100 text-green-800 p-2 rounded-md" title="Setujui" data-id="{{ $jadwal->id }}">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <button type="button" class="reject-btn bg-red-100 text-red-800 p-2 rounded-md" title="Tolak">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                                @endif
                                <a href="{{ route('dosen.dokumen.online') }}" class="bg-green-500 text-white p-2 rounded-md" title="Detail">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="border-t">
                        <td colspan="6" class="py-6 text-center text-gray-500">Tidak ada jadwal bimbingan mendatang</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Fixed approve modal -->
    <div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Pilih Metode Bimbingan</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" id="closeApproveModal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="metode" class="block text-sm font-medium text-gray-700 mb-1">Metode</label>
                    <select id="metode" name="metode" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required>
                        <option value="">-- Pilih Metode --</option>
                        <option value="online">Online Meeting</option>
                        <option value="offline">Offline Meeting</option>
                    </select>
                </div>
                <div class="mb-4" id="keteranganOfflineContainer" style="display: none;">
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea id="keterangan" name="keterangan" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelApprove" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Setujui</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-auto">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Alasan Penolakan</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" id="closeRejectModal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="keterangan_ditolak" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <textarea id="keterangan_ditolak" name="keterangan_ditolak" rows="4" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500" required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="cancelReject" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg mr-2 hover:bg-gray-300">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Hidden form for accept action -->
    <form id="acceptForm" method="POST" style="display: none;">
        @csrf
        <input type="text" name="keterangan" id="keterangan-input">
    </form>
</div>

@push('scripts')
<script>

document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const approveModal = document.getElementById('approveModal');
    const rejectModal = document.getElementById('rejectModal');
    const approveForm = document.getElementById('approveForm');
    const rejectForm = document.getElementById('rejectForm');
    const metodeSelect = document.getElementById('metode');
    const keteranganOfflineContainer = document.getElementById('keteranganOfflineContainer');

    // Get all approve buttons
    const approveButtons = document.querySelectorAll('.approve-btn');
    const rejectButtons = document.querySelectorAll('.reject-btn');

    // Close buttons
    const closeApproveModal = document.getElementById('closeApproveModal');
    const closeRejectModal = document.getElementById('closeRejectModal');
    const cancelApprove = document.getElementById('cancelApprove');
    const cancelReject = document.getElementById('cancelReject');

    // Current jadwal ID being processed
    let currentJadwalId = null;

    // Event listeners for approve buttons
    approveButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentJadwalId = this.getAttribute('data-id');

            // Set the form action with the correct ID
            approveForm.action = `/dosen/jadwal-bimbingan/accept/${currentJadwalId}`;

            // Pre-select metode if it exists in the row data
            const row = this.closest('tr');
            if (row) {
                const metode = row.getAttribute('data-metode');
                if (metode) {
                    metodeSelect.value = metode;
                    // Show/hide keterangan container based on metode
                    keteranganOfflineContainer.style.display = metode === 'offline' ? 'block' : 'none';
                }
            }

            // Show the modal
            approveModal.classList.remove('hidden');
        });
    });

    // Event listeners for reject buttons
    rejectButtons.forEach(button => {
        button.addEventListener('click', function() {
            currentJadwalId = this.closest('tr').getAttribute('data-id');

            // Set the form action with the correct ID
            rejectForm.action = `/jadwal-bimbingan/reject/${currentJadwalId}`;

            // Show the modal
            rejectModal.classList.remove('hidden');
        });
    });

    // Handle metode change
    metodeSelect.addEventListener('change', function() {
        keteranganOfflineContainer.style.display = this.value === 'offline' ? 'block' : 'none';
    });

    // Close modal handlers
    function closeApproveModalHandler() {
        approveModal.classList.add('hidden');
        currentJadwalId = null;
    }

    function closeRejectModalHandler() {
        rejectModal.classList.add('hidden');
        currentJadwalId = null;
    }

    // Attach close handlers
    closeApproveModal.addEventListener('click', closeApproveModalHandler);
    cancelApprove.addEventListener('click', closeApproveModalHandler);
    closeRejectModal.addEventListener('click', closeRejectModalHandler);
    cancelReject.addEventListener('click', closeRejectModalHandler);

    // Form submission (prevent if needed)
    approveForm.addEventListener('submit', function(e) {
        // You can add validation here if needed
        // If metode is required and not selected
        if (!metodeSelect.value) {
            e.preventDefault();
            alert('Silakan pilih metode bimbingan terlebih dahulu');
        }
    });

    rejectForm.addEventListener('submit', function(e) {
        // You can add validation here if needed
        const keteranganDitolak = document.getElementById('keterangan_ditolak');
        if (!keteranganDitolak.value.trim()) {
            e.preventDefault();
            alert('Silakan isi alasan penolakan terlebih dahulu');
        }
    });
});

    // document.querySelectorAll('.approve-btn').forEach(button => {
    //     button.addEventListener('click', function () {
    //         const id = this.dataset.id;
    //         const metode = this.closest('tr').dataset.metode;

    //         const form = document.getElementById('approveForm');
    //         form.action = `/dosen/jadwal-bimbingan/accept/${id}`;

    //         // Show modal
    //         document.getElementById('approveModal').classList.remove('hidden');

    //         // Optional: set default value in select if needed
    //         document.getElementById('metode').value = metode;
    //     });
    // });

    // document.getElementById('closeApproveModal').addEventListener('click', () => {
    //     document.getElementById('approveModal').classList.add('hidden');
    // });

    // document.getElementById('cancelApprove').addEventListener('click', () => {
    //     document.getElementById('approveModal').classList.add('hidden');
    // });

    // // Tampilkan keterangan jika metode offline dipilih
    // document.getElementById('metode').addEventListener('change', function () {
    //     const isOffline = this.value === 'offline';
    //     document.getElementById('keteranganOfflineContainer').style.display = isOffline ? 'block' : 'none';
    // });

    // Search functionality
    document.getElementById('search').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let table = document.querySelector('table');
        let rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            let text = row.textContent.toLowerCase();
            if(text.indexOf(input) > -1) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // // Reject Modal functionality
    // const rejectModal = document.getElementById('rejectModal');
    // const rejectForm = document.getElementById('rejectForm');

    // document.querySelectorAll('.reject-btn').forEach(button => {
    //     button.addEventListener('click', function() {
    //         let row = this.closest('tr');
    //         currentJadwalId = row.dataset.id;

    //         // Set the form action
    //         rejectForm.action = '{{ url("dosen/jadwal-bimbingan/reject") }}/' + currentJadwalId;

    //         // Show modal
    //         rejectModal.classList.remove('hidden');
    //     });
    // });

    // // Close modal
    // document.getElementById('closeRejectModal').addEventListener('click', function() {
    //     rejectModal.classList.add('hidden');
    // });

    // document.getElementById('cancelReject').addEventListener('click', function() {
    //     rejectModal.classList.add('hidden');
    // });

    // // Close modal when clicking outside
    // rejectModal.addEventListener('click', function(e) {
    //     if (e.target === rejectModal) {
    //         rejectModal.classList.add('hidden');
    //     }
    // });
</script>
@endpush
@endsection
