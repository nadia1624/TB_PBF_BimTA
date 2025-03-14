@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header Section with Search -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Kelola Dosen</h2>

        <div class="relative mt-4 md:mt-0">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                </svg>
            </div>
            <input type="text" id="searchQuery" class="block w-full md:w-80 pl-10 pr-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-full shadow-md focus:ring-blue-500 focus:border-blue-500" placeholder="Cari dosen...">
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer" class="hidden border-l-4 p-4 mb-6" role="alert">
        <p id="alertMessage"></p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div class="relative inline-block w-full md:w-auto">
            <button onclick="toggleBidangDropdown()" class="w-full md:w-48 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between shadow-md" type="button">
                <span id="selectedBidangText" class="truncate">Semua Bidang</span>
                <svg class="w-2.5 h-2.5 ml-2.5 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                </svg>
            </button>

            <div id="bidangDropdown" class="hidden absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow-lg w-full md:w-48">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="#" onclick="selectBidang('all', 'Semua Bidang'); return false;" class="block px-4 py-2 hover:bg-gray-100">Semua Bidang</a>
                    </li>
                    @foreach($bidang_keahlian as $bidang)
                    <li>
                        <a href="#" onclick="selectBidang('{{ $bidang->id }}', '{{ $bidang->nama_keahlian }}'); return false;" class="block px-4 py-2 hover:bg-gray-100">{{ $bidang->nama_keahlian }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <button type="button" onclick="openModal('tambahBidangModal')" class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Bidang
            </button>
            <button type="button" onclick="openModal('tambahDosenModal')" class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Dosen
            </button>
        </div>
    </div>

    <!-- Table Section -->
    <div class="overflow-x-auto shadow-xl rounded-lg bg-white">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4">NIP</th>
                    <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-4">Email</th>
                    <th scope="col" class="px-6 py-4">Bidang Keahlian</th>
                    <th scope="col" class="px-6 py-4 text-center">Mahasiswa Bimbingan</th>
                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="dosenTableBody">
                @foreach($dosen as $item)
                <tr class="bg-white border-b hover:bg-gray-50 dosen-row" data-bidang="{{ $item->bidang_keahlian_id }}">
                    <td class="px-6 py-4 font-medium">{{ $item->nip }}</td>
                    <td class="px-6 py-4">{{ $item->nama_lengkap }}</td>
                    <td class="px-6 py-4">{{ $item->user->email }}</td>
                    <td class="px-6 py-4">
                        @if($item->detailBidang->isNotEmpty())
                            @foreach($item->detailBidang as $bidang)
                                {{ optional($bidang->bidangKeahlian)->nama_keahlian ?? 'Belum ditentukan' }}<br>
                            @endforeach
                        @else
                            <span class="text-yellow-500">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $item->mahasiswa_count ?? '0' }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">
                            <button type="button" onclick="editDosen({{ $item->id }})"
                                class="bg-[#FBDA00] text-white hover:bg-yellow-300 border border-transparent focus:ring-4 focus:ring-[#FBDA00]-300 rounded-lg p-2"
                                title="Edit">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>

                            <button type="button" onclick="viewDosenDetail({{ $item}})"
                            class="bg-[#638B35] text-white hover:text-white border hover:bg-[#7FAF50] focus:ring-4 focus:ring-lime-300 rounded-lg p-2" title="Lihat Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                  </svg>
                            </button>
                            <button type="button" onclick="confirmDelete({{ $item->id }})"
                                class="bg-red-700 text-white hover:text-white border border-red-700 hover:bg-red-500 focus:ring-4 focus:ring-red-300 rounded-lg p-2" title="Hapus">
                                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Bidang -->
<div id="tambahBidangModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('tambahBidangModal')"></div>

    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                    Tambah Bidang Keahlian
                </h3>
                <button type="button" onclick="closeModal('tambahBidangModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="bidangForm" action="{{ route('admin.bidang.create') }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label for="nama_keahlian" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Nama Bidang Keahlian</label>
                        <input type="text" name="nama_keahlian" id="nama_keahlian" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black" placeholder="Masukkan nama bidang" required>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                    <button type="button" onclick="closeModal('tambahBidangModal')" class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Dosen -->
<div id="tambahDosenModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('tambahDosenModal')"></div>

    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black text-center w-full">
                    Tambah Dosen Pembimbing Baru
                </h3>
                <button type="button" onclick="closeModal('tambahDosenModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="dosenForm" action="{{ route('admin.dosen.store') }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4 max-h-[60vh] overflow-y-auto">
                    <!-- Informasi Pribadi Section -->
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-bklack border-b pb-2">Informasi Pribadi</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">NIP</label>
                            <input type="text" name="nip" id="nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Nomor Induk Pegawai" required>
                        </div>
                        <div>
                            <label for="nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Nama lengkap dosen" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="bidang_keahlian_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Bidang Keahlian</label>
                            <select name="bidang_keahlian_id" id="bidang_keahlian_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" required>
                                <option value="">Pilih Bidang Keahlian</option>
                                @foreach($bidang_keahlian as $bidang)
                                <option value="{{ $bidang->id }}">{{ $bidang->nama_keahlian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Informasi Akun Section -->
                    <div class="pt-4 mb-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-black border-b pb-2">Informasi Akun</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Email</label>
                            <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Email dosen" required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Password</label>
                            <input type="password" name="password" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Password untuk login" required>
                        </div>
                        <div>
                            <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Ketik ulang password" required>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#638B35]-600 dark:hover:bg-lime-700 dark:focus:ring-lime-800">Simpan</button>
                    <button type="button" onclick="closeModal('tambahDosenModal')" class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Dosen -->
<div id="editDosenModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('editDosenModal')"></div>

    <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                    Edit Dosen
                </h3>
                <button type="button" onclick="closeModal('editDosenModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="editDosenForm" action="{{ route('admin.dosen.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="dosen_id" id="edit_dosen_id">
                <div class="p-4 md:p-5 space-y-4 max-h-[60vh] overflow-y-auto">
                    <!-- Informasi Pribadi Section -->
                    <div class="mb-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-black border-b pb-2">Informasi Pribadi</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="edit_nip" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">NIP</label>
                            <input type="text" name="nip" id="edit_nip" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Nomor Induk Pegawai" required>
                        </div>
                        <div>
                            <label for="edit_nama_lengkap" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" id="edit_nama_lengkap" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Nama lengkap dosen" required>
                        </div>
                        <div class="md:col-span-2">
                            <label for="edit_bidang_keahlian_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Bidang Keahlian</label>
                            <select name="bidang_keahlian_id" id="edit_bidang_keahlian_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" required>
                                <option value="">Pilih Bidang Keahlian</option>
                                @foreach($bidang_keahlian as $bidang)
                                <option value="{{ $bidang->id }}">{{ $bidang->nama_keahlian }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Informasi Akun Section -->
                    <div class="pt-4 mb-4">
                        <h4 class="text-lg font-medium text-gray-900 dark:text-black border-b pb-2">Informasi Akun</h4>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="edit_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Email</label>
                            <input type="email" name="email" id="edit_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Email dosen" required>
                        </div>

                        <div class="md:col-span-2">
                            <div class="flex items-center mb-4">
                                <input type="checkbox" id="change_password" onclick="togglePasswordFields()" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500">
                                <label for="change_password" class="ml-2 text-sm font-medium text-gray-900 dark:text-black">Ubah Password</label>
                            </div>
                        </div>

                        <div id="password_fields" class="hidden md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="edit_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Password Baru</label>
                                <input type="password" name="password" id="edit_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Password baru">
                            </div>
                            <div>
                                <label for="edit_password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="edit_password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-black" placeholder="Konfirmasi password baru">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="submit" class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-[#638B35]-700 dark:hover:bg-lime-700 dark:focus:ring-lime-800">Simpan Perubahan</button>
                    <button type="button" onclick="closeModal('editDosenModal')" class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Dosen -->
<div id="deleteDosenModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('deleteDosenModal')"></div>

    <div class="relative w-full max-w-md max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-white-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                    Konfirmasi Hapus
                </h3>
                <button type="button" onclick="closeModal('deleteDosenModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-black-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-white-600 dark:hover:text-black">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-red-600 w-12 h-12 dark:text-black-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-800 dark:text-black-400">Apakah Anda yakin ingin menghapus dosen ini?</h3>
                <p class="mb-5 text-sm text-gray-700 dark:text-black-300">Tindakan ini tidak dapat dibatalkan dan akan menghapus semua data terkait dosen ini.</p>
                <form id="deleteDosenForm" action="{{ route('admin.dosen.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="dosen_id" id="delete_dosen_id">
                    <div class="flex justify-center gap-4">
                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Ya, hapus
                        </button>
                        <button type="button" onclick="closeModal('deleteDosenModal')" class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Dosen -->
<div id="detailDosenModal" class="hidden fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full flex items-center justify-center">
    <div class="fixed inset-0 bg-black bg-opacity-50" onclick="closeModal('detailDosenModal')"></div>

    <div class="relative w-full max-w-xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                    Detail Dosen
                </h3>
                <button type="button" onclick="closeModal('detailDosenModal')" class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Tutup</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 max-h-[70vh] overflow-y-auto" id="dosenDetailContent">
                <!-- Detail dosen will be loaded here via AJAX -->
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="button" onclick="closeModal('detailDosenModal')" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Flowbite components if needed
        if (typeof window.Flowbite !== 'undefined') {
            window.Flowbite.init();
        }

        @if(session('success'))
            showAlert('success', "{{ session('success') }}");
        @endif

        @if(session('error'))
            showAlert('error', "{{ session('error') }}");
        @endif
    });

    // Show or hide a modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Toggle bidang dropdown
    function toggleBidangDropdown() {
        const dropdown = document.getElementById('bidangDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Select bidang option
    function selectBidang(id, name) {
        document.getElementById('selectedBidangText').textContent = name;
        document.getElementById('bidangDropdown').classList.add('hidden');
        filterTable(id);
    }

    // Filter table by bidang and search query
    function filterTable(bidangId = 'all') {
        const searchQuery = document.getElementById('searchQuery').value.toLowerCase();
        const rows = document.querySelectorAll('.dosen-row');

        rows.forEach(row => {
            const rowBidang = row.getAttribute('data-bidang');
            const nip = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
            const nama = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            const email = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

            // Filter by bidang
            const matchBidang = bidangId === 'all' || rowBidang === bidangId;

            // Filter by search query
            const matchSearch = searchQuery === '' ||
                nip.includes(searchQuery) ||
                nama.includes(searchQuery) ||
                email.includes(searchQuery);

            // Show row if it matches both filters
            if (matchBidang && matchSearch) {
                row.classList.remove('hidden');
            } else {
                row.classList.add('hidden');
            }
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

    // Edit dosen
    function editDosen(id) {
        // Fetch dosen data and populate form
        fetch(`/admin/dosen/${id}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const dosen = data.dosen;

                // Set form values
                document.getElementById('edit_dosen_id').value = dosen.id;
                document.getElementById('edit_nip').value = dosen.nip;
                document.getElementById('edit_nama_lengkap').value = dosen.nama_lengkap;
                document.getElementById('edit_email').value = dosen.user.email;

                // Set bidang keahlian
                const bidangKeahlianId = dosen.bidang_keahlian_id ||
                    (dosen.detailBidang && dosen.detailBidang.length > 0 ?
                        dosen.detailBidang[0].bidang_keahlian_id : '');
                document.getElementById('edit_bidang_keahlian_id').value = bidangKeahlianId;

                // Reset password fields
                document.getElementById('change_password').checked = false;
                document.getElementById('password_fields').classList.add('hidden');
                document.getElementById('edit_password').value = '';
                document.getElementById('edit_password_confirmation').value = '';

                // Open modal
                openModal('editDosenModal');
            } else {
                showAlert('error', data.message || 'Gagal mengambil data dosen');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat mengambil data dosen');
        });
    }

    // Toggle password fields in edit form
    function togglePasswordFields() {
        const isChecked = document.getElementById('change_password').checked;
        const passwordFields = document.getElementById('password_fields');

        if (isChecked) {
            passwordFields.classList.remove('hidden');
        } else {
            passwordFields.classList.add('hidden');
        }
    }

    // Confirm delete dosen
    function confirmDelete(id) {
        document.getElementById('delete_dosen_id').value = id;
        openModal('deleteDosenModal');
    }

    // View dosen detail
    function viewDosenDetail(dosen) {
        // Fetch dosen details

                const detailContainer = document.getElementById('dosenDetailContent');
                openModal('detailDosenModal');

                // Build detail HTML
                let bidangHtml = '';
                if (dosen.detailBidang && dosen.detailBidang.length > 0) {
                    bidangHtml = dosen.detailBidang.map(b =>
                        b.bidangKeahlian ? b.bidangKeahlian.nama_keahlian : 'Belum ditentukan'
                    ).join('<br>');
                } else {
                    bidangHtml = '<span class="text-yellow-500">Belum ditentukan</span>';
                }

                // Create mahasiswa table HTML if there are mahasiswa
                let mahasiswaHtml = '';
                if (dosen.mahasiswas && dosen.mahasiswas.length > 0) {
                    mahasiswaHtml = `
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-800">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-4 py-3">NIM</th>
                                        <th scope="col" class="px-4 py-3">Nama</th>
                                        <th scope="col" class="px-4 py-3">Judul</th>
                                        <th scope="col" class="px-4 py-3">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${dosen.mahasiswas.map(mhs => `
                                        <tr class="bg-white border-b hover:bg-gray-50">
                                            <td class="px-4 py-3">${mhs.nim || ''}</td>
                                            <td class="px-4 py-3">${mhs.nama || ''}</td>
                                            <td class="px-4 py-3">${mhs.judul || ''}</td>
                                            <td class="px-4 py-3">
                                                <span class="${mhs.status === 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'} text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                    ${mhs.status || ''}
                                                </span>
                                            </td>
                                        </tr>
                                    `).join('')}
                                </tbody>
                            </table>
                        </div>
                    `;
                } else {
                    mahasiswaHtml = '<p class="text-gray-500 dark:text-gray-400 text-center py-3">Belum ada mahasiswa bimbingan</p>';
                }

                // Set content
                detailContainer.innerHTML = `
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="text-sm">
                                <p class="text-gray-500 dark:text-black-400">NIP</p>
                                <p class="font-medium text-gray-900 dark:text-black">${dosen.nip}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500 dark:text-black-400">Nama Lengkap</p>
                                <p class="font-medium text-gray-900 dark:text-black">${dosen.nama_lengkap}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500 dark:text-black-400">Email</p>
                                <p class="font-medium text-gray-900 dark:text-black">${dosen.user ? dosen.user.email : ''}</p>
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-500 dark:text-black-400">Bidang Keahlian</p>
                                <p class="font-medium text-gray-900 dark:text-black">${bidangHtml}</p>
                            </div>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-lg font-medium text-gray-900 dark:text-black mb-4">Mahasiswa Bimbingan</h4>
                            ${mahasiswaHtml}
                        </div>
                    </div>
                `;


    }

    // Setup search functionality
    document.getElementById('searchQuery').addEventListener('keyup', function() {
        const bidangId = document.getElementById('selectedBidangText').textContent === 'Semua Bidang' ? 'all' : null;
        filterTable(bidangId);
    });
</script>
@endpush
