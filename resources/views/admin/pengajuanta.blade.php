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
                        <a href="#" onclick="selectFilter('status', 'Diterima', 'Diterima'); return false;" class="block px-4 py-2 hover:bg-gray-100">Diterima</a>
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
                            $status = 'diproses';

                            // Get status from detail_dosen
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
                        <button type="button" onclick="viewDetail({{ $item->id }})" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg p-2" title="Lihat Detail">
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
@endsection

@push('scripts')
<script>
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

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(event) {
        const bidangDropdown = document.getElementById('bidangDropdown');
        const statusDropdown = document.getElementById('statusDropdown');

        if (!event.target.closest('[onclick="toggleDropdown(\'bidangDropdown\')"]') && !bidangDropdown.contains(event.target)) {
            bidangDropdown.classList.add('hidden');
        }

        if (!event.target.closest('[onclick="toggleDropdown(\'statusDropdown\')"]') && !statusDropdown.contains(event.target)) {
            statusDropdown.classList.add('hidden');
        }
    });
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

function getActionButton(item) {
    const url = `/admin/pengajuan-ta/${item.id}/detail`;  // or generate this with a route helper if possible in JS
    return `
        <a href="${url}" class="text-green-700 hover:text-white border border-green-700 hover:bg-green-700 focus:ring-4 focus:ring-green-300 rounded-lg p-2 inline-flex" title="Lihat Detail">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </a>
    `;
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

        // Determine status and its class
        let status = 'diproses';
        let statusLabel = 'Diproses';
        let statusClass = 'bg-yellow-100 text-yellow-800';

        if (item.detail_dosen && item.detail_dosen.length > 0) {
            const detailDosen = item.detail_dosen[0];
            status = detailDosen.status;

            if (status === 'diterima') {
                statusLabel = 'Diterima';
                statusClass = 'bg-green-100 text-green-800';
            } else if (status === 'ditolak') {
                statusLabel = 'Ditolak';
                statusClass = 'bg-red-100 text-red-800';
            } else if (status === 'diproses') {
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
                ${getActionButton(item)}
            </td>
        `;

        tableBody.appendChild(row);
    });
}

// Action function
function viewDetail(id) {
    window.location.href = '/admin/pengajuan-ta/' + id + '/detail';
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
</script>
@endpush
