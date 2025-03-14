@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section with Search -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Daftar Pengajuan TA</h2>

        <div class="relative mt-4 md:mt-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="searchQuery" class="block w-full md:w-80 pl-10 pr-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-full shadow-md focus:ring-blue-500 focus:border-blue-500" placeholder="Cari mahasiswa atau judul...">
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer" class="hidden border-l-4 p-4 mb-6" role="alert">
        <p id="alertMessage"></p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <!-- Filter Bidang -->
        <div class="relative inline-block w-full md:w-auto">
            <button onclick="toggleDropdown('bidangDropdown')" class="w-full md:w-48 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between shadow-md" type="button">
                <span id="selectedBidangText" class="truncate">Semua Bidang</span>
                <svg class="w-2.5 h-2.5 ml-2.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <div id="bidangDropdown" class="hidden absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-full md:w-48">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="#" onclick="selectFilter('bidang', 'all', 'Semua Bidang'); return false;" class="block px-4 py-2 hover:bg-gray-100">Semua Bidang</a>
                    </li>
                    @foreach($bidang_keahlian as $bidang)
                    <li>
                        <a href="#" onclick="selectFilter('bidang', '{{ $bidang->id }}', '{{ $bidang->nama_keahlian }}'); return false;" class="block px-4 py-2 hover:bg-gray-100">{{ $bidang->nama_keahlian }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Filter Status -->
        <div class="relative inline-block w-full md:w-auto">
            <button onclick="toggleDropdown('statusDropdown')" class="w-full md:w-48 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between shadow-md" type="button">
                <span id="selectedStatusText" class="truncate">Semua Status</span>
                <svg class="w-2.5 h-2.5 ml-2.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <div id="statusDropdown" class="hidden absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-full md:w-48">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="#" onclick="selectFilter('status', 'all', 'Semua Status'); return false;" class="block px-4 py-2 hover:bg-gray-100">Semua Status</a>
                    </li>
                    <li>
                        <a href="#" onclick="selectFilter('status', 'Diproses', 'Diproses'); return false;" class="block px-4 py-2 hover:bg-gray-100">Diproses</a>
                    </li>
                    <li>
                        <a href="#" onclick="selectFilter('status', 'Disetujui', 'Disetujui'); return false;" class="block px-4 py-2 hover:bg-gray-100">Disetujui</a>
                    </li>
                    <li>
                        <a href="#" onclick="selectFilter('status', 'Ditolak', 'Ditolak'); return false;" class="block px-4 py-2 hover:bg-gray-100">Ditolak</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto shadow-xl rounded-lg bg-white">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4">MAHASISWA</th>
                    <th scope="col" class="px-6 py-4">JUDUL</th>
                    <th scope="col" class="px-6 py-4">DOSEN PEMBIMBING</th>
                    <th scope="col" class="px-6 py-4">TANGGAL</th>
                    <th scope="col" class="px-6 py-4 text-center">STATUS</th>
                    <th scope="col" class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody id="pengajuanTableBody">
                @foreach($pengajuan as $item)
                <tr class="bg-white border-b hover:bg-gray-50 pengajuan-row" data-id="{{ $item->id }}" data-mahasiswa="{{ optional($item->mahasiswa)->id }}">
                    <td class="px-6 py-4 font-medium">{{ optional($item->mahasiswa)->nama_lengkap }}</td>
                    <td class="px-6 py-4">{{ $item->judul }}</td>
                    <td class="px-6 py-4">
                        @if($item->detailDosen->isNotEmpty())
                            @foreach($item->detailDosen as $detail)
                                {{ optional($detail->dosen)->nama_lengkap }}<br>
                            @endforeach
                        @else
                            <span class="text-yellow-500">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $item->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $statusLabel = 'Diproses';
                            $statusClass = 'bg-yellow-100 text-yellow-800';

                            // Get status from detail_dosen instead of approved_ta
                            if($item->detailDosen->isNotEmpty()) {
                                $detailDosen = $item->detailDosen->first();
                                $status = $detailDosen->status;

                                if($status == 'diterima') {
                                    $statusLabel = 'Diterima';
                                    $statusClass = 'bg-green-100 text-green-800';
                                } elseif($status == 'ditolak') {
                                    $statusLabel = 'Ditolak';
                                    $statusClass = 'bg-red-100 text-red-800';
                                } elseif($status == 'diproses') {
                                    $statusLabel = 'Diproses';
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                }
                            }
                        @endphp
                        <span class="{{ $statusClass }} text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $statusLabel }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button type="button" onclick="viewPengajuanDetail({{ $item->id }})" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg p-2" title="Lihat Detail">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Detail Pengajuan -->
<div id="detailPengajuanModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('detailPengajuanModal')"></div>

    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Detail Pengajuan TA
                </h3>
                <button type="button" onclick="closeModal('detailPengajuanModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 max-h-[70vh] overflow-y-auto" id="pengajuanDetailContent">
                <!-- Detail pengajuan will be loaded here via AJAX -->
            </div>
            <!-- Modal action buttons -->
            <div class="flex items-center justify-between p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <div id="statusActionButtons" class="flex gap-2">
                    <button type="button" id="btnApprove" onclick="updateStatus('Disetujui')" class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Setujui</button>
                    <button type="button" id="btnReject" onclick="openRejectForm()" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tolak</button>
                </div>
                <button type="button" onclick="closeModal('detailPengajuanModal')" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tutup</button>
            </div>

            <!-- Rejection form (initially hidden) -->
            <div id="rejectFormContainer" class="hidden p-4 md:p-5 border-t border-gray-200">
                <h4 class="text-lg font-medium text-gray-900 mb-4">Alasan Penolakan</h4>
                <form id="rejectForm">
                    <textarea id="rejectReason" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-4" rows="3" placeholder="Masukkan alasan penolakan"></textarea>
                    <div class="flex gap-2">
                        <button type="button" onclick="updateStatus('Ditolak')" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Konfirmasi Penolakan</button>
                        <button type="button" onclick="closeRejectForm()" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentPengajuanId = null;
let currentDetailId = null;
let filters = {
    bidang: 'all',
    status: 'all',
    search: ''
};

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Flowbite components if needed
    if (typeof window.Flowbite !== 'undefined') {
        window.Flowbite.init();
    }

    // Search input event
    document.getElementById('searchQuery').addEventListener('input', function() {
        filters.search = this.value;
        applyFilters();
    });

    @if(session('success'))
        showAlert('success', "{{ session('success') }}");
    @endif

    @if(session('error'))
        showAlert('error', "{{ session('error') }}");
    @endif
});

// Toggle dropdown
function toggleDropdown(dropdownId) {
    document.getElementById(dropdownId).classList.toggle('hidden');
}

// Select filter option
function selectFilter(type, value, text) {
    if (type === 'bidang') {
        document.getElementById('selectedBidangText').textContent = text;
        document.getElementById('bidangDropdown').classList.add('hidden');
        filters.bidang = value;
    } else if (type === 'status') {
        document.getElementById('selectedStatusText').textContent = text;
        document.getElementById('statusDropdown').classList.add('hidden');
        filters.status = value;
    }
    applyFilters();
}

// Apply all filters
function applyFilters() {
    fetch("{{ route('admin.pengajuanta.filter') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(filters)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateTable(data.data);
        } else {
            showAlert('error', data.message || 'Terjadi kesalahan saat memfilter data');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan pada server');
    });
}

// Update table with filtered data
function updateTable(pengajuan) {
    const tableBody = document.getElementById('pengajuanTableBody');
    tableBody.innerHTML = '';

    if (pengajuan.length === 0) {
        const emptyRow = document.createElement('tr');
        emptyRow.innerHTML = `
            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                Tidak ada data pengajuan yang ditemukan
            </td>
        `;
        tableBody.appendChild(emptyRow);
        return;
    }

    pengajuan.forEach(item => {
        const row = document.createElement('tr');
        row.className = 'bg-white border-b hover:bg-gray-50 pengajuan-row';
        row.setAttribute('data-id', item.id);
        row.setAttribute('data-mahasiswa', item.mahasiswa ? item.mahasiswa.id : '');

        // Determine status and its class from detail_dosen instead of approved_ta
        let statusLabel = 'Diproses';
        let statusClass = 'bg-yellow-100 text-yellow-800';

        if (item.detail_dosen && item.detail_dosen.length > 0) {
            const detailDosen = item.detail_dosen[0];
            if (detailDosen.status === 'disetujui') {
                statusLabel = 'Disetujui';
                statusClass = 'bg-green-100 text-green-800';
            } else if (detailDosen.status === 'ditolak') {
                statusLabel = 'Ditolak';
                statusClass = 'bg-red-100 text-red-800';
            } else if (detailDosen.status === 'diproses') {
                statusLabel = 'Diproses';
                statusClass = 'bg-yellow-100 text-yellow-800';
            }
        }

        // Generate dosen list
        let dosenHtml = '<span class="text-yellow-500">Belum ditentukan</span>';
        if (item.detail_dosen && item.detail_dosen.length > 0) {
            const dosenList = item.detail_dosen.map(detail => {
                return detail.dosen ? detail.dosen.nama_lengkap : '';
            }).filter(Boolean);

            if (dosenList.length > 0) {
                dosenHtml = dosenList.join('<br>');
            }
        }

        // Format date
        const createdAt = new Date(item.created_at);
        const formattedDate = `${createdAt.getDate().toString().padStart(2, '0')}/${(createdAt.getMonth() + 1).toString().padStart(2, '0')}/${createdAt.getFullYear()}`;

        row.innerHTML = `
            <td class="px-6 py-4 font-medium">${item.mahasiswa ? item.mahasiswa.nama_lengkap : ''}</td>
            <td class="px-6 py-4">${item.judul}</td>
            <td class="px-6 py-4">${dosenHtml}</td>
            <td class="px-6 py-4">${formattedDate}</td>
            <td class="px-6 py-4 text-center">
                <span class="${statusClass} text-xs font-medium px-2.5 py-0.5 rounded-full">${statusLabel}</span>
            </td>
            <td class="px-6 py-4 text-center">
                <button type="button" onclick="viewPengajuanDetail(${item.id})" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg p-2" title="Lihat Detail">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </td>
        `;

        tableBody.appendChild(row);
    });
}

// Show or hide a modal
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    // Reset rejection form if closing main modal
    if (modalId === 'detailPengajuanModal') {
        closeRejectForm();
    }
}

// Show rejection form
function openRejectForm() {
    document.getElementById('statusActionButtons').classList.add('hidden');
    document.getElementById('rejectFormContainer').classList.remove('hidden');
}

// Hide rejection form
function closeRejectForm() {
    document.getElementById('statusActionButtons').classList.remove('hidden');
    document.getElementById('rejectFormContainer').classList.add('hidden');
    document.getElementById('rejectReason').value = '';
}

// View pengajuan detail
function viewPengajuanDetail(id) {
    fetch(`/admin/pengajuan-ta/${id}/detail`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const pengajuan = data.data;
            currentPengajuanId = pengajuan.id;

            // Find the first detailDosen entry to get the ID for status updates
            if (pengajuan.detail_dosen && pengajuan.detail_dosen.length > 0) {
                currentDetailId = pengajuan.detail_dosen[0].id;
            }

            const detailContainer = document.getElementById('pengajuanDetailContent');

            // Format date
            const createdAt = new Date(pengajuan.created_at);
            const formattedDate = `${createdAt.getDate().toString().padStart(2, '0')}/${(createdAt.getMonth() + 1).toString().padStart(2, '0')}/${createdAt.getFullYear()}`;

            // Get status information
            let statusLabel = 'Diproses';
            let statusClass = 'bg-yellow-100 text-yellow-800';
            let alasanDibatalkan = '';

            if (pengajuan.approved_ta === 'disetujui') {
                statusLabel = 'Disetujui';
                statusClass = 'bg-green-100 text-green-800';
            } else if (pengajuan.approved_ta === 'ditolak') {
                statusLabel = 'Ditolak';
                statusClass = 'bg-red-100 text-red-800';
            }

            if (pengajuan.detail_dosen && pengajuan.detail_dosen.length > 0) {
                alasanDibatalkan = pengajuan.detail_dosen[0].alasan_dibatalkan || '';
            }

            // Show/hide action buttons based on status
            const btnApprove = document.getElementById('btnApprove');
            const btnReject = document.getElementById('btnReject');

            if (pengajuan.approved_ta === 'disetujui' || pengajuan.approved_ta === 'ditolak') {
                btnApprove.classList.add('hidden');
                btnReject.classList.add('hidden');
            } else {
                btnApprove.classList.remove('hidden');
                btnReject.classList.remove('hidden');
            }

            // Build detail HTML
            let detailHtml = `
                <div class="space-y-6">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-lg font-medium text-gray-900">Detail Pengajuan</h4>
                        <span class="${statusClass} text-xs font-medium px-3 py-1 rounded-full">${statusLabel}</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-b pb-4">
                        <div class="text-sm">
                            <p class="text-gray-500">Tanggal Pengajuan</p>
                            <p class="font-medium text-gray-900">${formattedDate}</p>
                        </div>
                        <div class="text-sm">
                            <p class="text-gray-500">Status</p>
                            <p class="font-medium text-gray-900">${statusLabel}</p>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Informasi Mahasiswa</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="text-sm">
                                <p class="text-gray-500">Nama Mahasiswa</p>
                                <p class="font-medium text-gray-900">${pengajuan.mahasiswa ? pengajuan.mahasiswa.nama_lengkap : '-'}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500">NIM</p>
                                <p class="font-medium text-gray-900">${pengajuan.mahasiswa ? pengajuan.mahasiswa.nim : '-'}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500">Program Studi</p>
                                <p class="font-medium text-gray-900">${pengajuan.mahasiswa ? pengajuan.mahasiswa.program_studi : '-'}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500">Angkatan</p>
                                <p class="font-medium text-gray-900">${pengajuan.mahasiswa ? pengajuan.mahasiswa.angkatan : '-'}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Detail Tugas Akhir</h4>
                        <div class="space-y-4">
                            <div class="text-sm">
                                <p class="text-gray-500">Judul</p>
                                <p class="font-medium text-gray-900">${pengajuan.judul}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500">Deskripsi</p>
                                <p class="text-gray-900">${pengajuan.deskripsi || '-'}</p>
                            </div>
                        </div>
                    </div>

                    <div class="border-b pb-4">
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Dosen Pembimbing</h4>
            `;

            if (pengajuan.detail_dosen && pengajuan.detail_dosen.length > 0) {
                pengajuan.detail_dosen.forEach(detail => {
                    if (detail.dosen) {
                        detailHtml += `
                            <div class="mb-3 p-3 border rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="text-sm">
                                        <p class="text-gray-500">Nama Dosen</p>
                                        <p class="font-medium text-gray-900">${detail.dosen.nama_lengkap}</p>
                                    </div>
                                    <div class="text-sm">
                                        <p class="text-gray-500">NIP</p>
                                        <p class="font-medium text-gray-900">${detail.dosen.nip}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }
                });
            } else {
                detailHtml += `<p class="text-gray-500 text-center py-3">Belum ada dosen pembimbing yang ditentukan</p>`;
            }

            detailHtml += `</div>`;

            // Add rejection reason if applicable
            if (pengajuan.approved_ta === 'ditolak' && pengajuan.komentar) {
                detailHtml += `
                    <div class="border-b pb-4">
                        <h4 class="text-lg font-medium text-red-700 mb-2">Alasan Penolakan</h4>
                        <div class="p-3 bg-red-50 rounded-lg text-red-800">
                            ${pengajuan.komentar}
                        </div>
                    </div>
                `;
            }

            // Close the space-y-6 div
            detailHtml += `</div>`;

            // Set the HTML content
            detailContainer.innerHTML = detailHtml;

            // Open the modal
            openModal('detailPengajuanModal');
        } else {
            showAlert('error', data.message || 'Gagal mengambil detail pengajuan');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat mengambil detail pengajuan');
    });
}

// Update status
function updateStatus(status) {
    if (!currentPengajuanId) {
        showAlert('error', 'ID pengajuan tidak ditemukan');
        return;
    }

    let data = {
        status: status
    };

    // Add rejection reason if rejecting
    if (status === 'Ditolak') {
        const reason = document.getElementById('rejectReason').value.trim();
        if (!reason) {
            showAlert('error', 'Harap isi alasan penolakan');
            return;
        }
        data.komentar = reason;
    }

    fetch(`/admin/pengajuan-ta/${currentPengajuanId}/status`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message || 'Status berhasil diperbarui');
            closeModal('detailPengajuanModal');
            // Refresh the data
            applyFilters();
        } else {
            showAlert('error', data.message || 'Gagal memperbarui status');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memperbarui status');
    });
}

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
