@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section with Search -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Kelola Mahasiswa</h2>

        <div class="relative mt-4 md:mt-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="table-search" class="block w-full md:w-80 pl-10 pr-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-full shadow-md focus:ring-blue-500 focus:border-blue-500" placeholder="Cari mahasiswa...">
        </div>
    </div>

    <!-- Actions Bar -->
    <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
        <div class="relative inline-block">
            <!-- Dropdown Button - Fixed Width -->
            <button id="dropdownAngkatanButton" data-dropdown-toggle="dropdownAngkatan" class="w-48 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between shadow-md" type="button">
                <span id="selected-angkatan" class="truncate">Semua Angkatan</span>
                <svg class="w-2.5 h-2.5 ml-2.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <!-- Dropdown menu - Fixed Width and Absolute Positioning -->
            <div id="dropdownAngkatan" class="absolute z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-48">
                <ul class="py-2 text-sm text-gray-700" aria-labelledby="dropdownAngkatanButton">
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 angkatan-filter" data-angkatan="all">Semua Angkatan</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 angkatan-filter" data-angkatan="2025">2025</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 angkatan-filter" data-angkatan="2024">2024</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 angkatan-filter" data-angkatan="2023">2023</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100 angkatan-filter" data-angkatan="2022">2022</a>
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
                    <th scope="col" class="px-6 py-4">NIM</th>
                    <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-4">Program Studi</th>
                    <th scope="col" class="px-6 py-4">Angkatan</th>
                    <th scope="col" class="px-6 py-4">No Telepon</th>
                    <th scope="col" class="px-6 py-4 text-center">Status</th>
                    <th scope="col" class="px-6 py-4 text-center">Progress</th>
                </tr>
            </thead>
            <tbody id="mahasiswa-table-body">
                @foreach ($mahasiswa as $mhs)
                <tr class="bg-white hover:bg-gray-50 border-b mahasiswa-row" data-angkatan="{{ $mhs->angkatan }}">
                    <td class="px-6 py-4 font-medium">{{ $mhs->nim }}</td>
                    <td class="px-6 py-4">{{ $mhs->nama_lengkap }}</td>
                    <td class="px-6 py-4">{{ $mhs->program_studi }}</td>
                    <td class="px-6 py-4">{{ $mhs->angkatan }}</td>
                    <td class="px-6 py-4">{{ $mhs->no_hp }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">Aktif</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col items-center text-xs">
                            <div class="flex items-center mb-1">
                                <span class="font-medium mr-2">Pengajuan:</span>
                                <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full">0</span>
                            </div>
                            <div class="flex items-center">
                                <span class="font-medium mr-2">Bimbingan:</span>
                                <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full">0</span>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    // Tunggu sampai DOM sepenuhnya dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const dropdownButton = document.getElementById('dropdownAngkatanButton');
        const dropdownMenu = document.getElementById('dropdownAngkatan');
        const filterItems = document.querySelectorAll('.angkatan-filter');
        const mahasiswaRows = document.querySelectorAll('.mahasiswa-row');
        const selectedText = document.getElementById('selected-angkatan');
        const searchInput = document.getElementById('table-search');

        // Toggle dropdown saat tombol di klik
        dropdownButton.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        // Menutup dropdown saat mengklik di luar dropdown
        document.addEventListener('click', function(e) {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Tambahkan event listener untuk setiap item filter
        filterItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Ambil nilai angkatan dari data attribute
                const angkatan = this.getAttribute('data-angkatan');

                // Update text pada dropdown button
                selectedText.textContent = this.textContent;

                // Filter tabel berdasarkan angkatan
                filterTable(angkatan, searchInput.value);

                // Sembunyikan dropdown setelah item dipilih
                dropdownMenu.classList.add('hidden');
            });
        });

        // Tambahkan event listener untuk pencarian
        searchInput.addEventListener('keyup', function() {
            const angkatan = selectedText.textContent === 'Semua Angkatan'
                ? 'all'
                : selectedText.textContent;

            filterTable(angkatan, this.value);
        });

        // Fungsi untuk memfilter tabel berdasarkan angkatan dan kata kunci pencarian
        function filterTable(angkatan, searchText) {
            const searchValue = searchText.toLowerCase().trim();

            mahasiswaRows.forEach(row => {
                const rowAngkatan = row.getAttribute('data-angkatan');
                const nim = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const prodi = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                // Filter berdasarkan angkatan
                const matchAngkatan = angkatan === 'all' || rowAngkatan === angkatan;

                // Filter berdasarkan pencarian
                const matchSearch = searchValue === '' ||
                    nim.includes(searchValue) ||
                    nama.includes(searchValue) ||
                    prodi.includes(searchValue);

                // Tampilkan baris jika cocok dengan kedua filter
                if (matchAngkatan && matchSearch) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        }

        // Menentukan posisi dropdown relatif terhadap button
        function positionDropdown() {
            const buttonRect = dropdownButton.getBoundingClientRect();
            dropdownMenu.style.top = buttonRect.height + 'px';
            dropdownMenu.style.left = '0';
        }

        // Sesuaikan posisi dropdown saat jendela diubah ukurannya
        window.addEventListener('resize', function() {
            if (!dropdownMenu.classList.contains('hidden')) {
                positionDropdown();
            }
        });

        // Posisi awal dropdown
        positionDropdown();
    });
</script>
@endpush

@endsection
