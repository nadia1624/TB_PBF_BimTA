@extends('layouts.admin')

@section('content')
<div
    x-data="{
        search: '{{ request('search') }}',
        user : null,
        angkatan: [],
        selectedAngkatan: null,
        filterByAngkatan(year) {
            let url = new URL(window.location.href);
            if (year === 'all') {
                url.searchParams.delete('angkatan'); // Hapus parameter angkatan
                this.selectedAngkatan = 'Semua Angkatan';
            } else {
                url.searchParams.set('angkatan', year); // Set parameter angkatan
                this.selectedAngkatan = year;
            }
            // Tambahkan parameter search yang ada jika tidak kosong
            if (this.search) {
                url.searchParams.set('search', this.search);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString(); // Muat ulang halaman dengan filter baru
        },

        applySearchFilter() {
            let url = new URL(window.location.href);

            const currentAngkatanParam = url.searchParams.get('angkatan');

            if (this.search) {
                url.searchParams.set('search', this.search);
            } else {
                url.searchParams.delete('search');
            }

            if (currentAngkatanParam) {
                url.searchParams.set('angkatan', currentAngkatanParam);
            } else {
                // Jika tidak ada parameter angkatan di URL, pastikan tidak ada di URL baru
                url.searchParams.delete('angkatan');
            }

            window.location.href = url.toString();
        },

        openModal(modal,user){
        this.$dispatch('open-modal', modal);
        console.log('Membuka modal:', modal, 'Data user:', user);
        this.user = user;
        },

        closeModal(){
        this.$dispatch('close');
        this.user = null;
        },
}">
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
            <input type="text" x-model="search" id="searchQuery"
                class="block w-full md:w-80 pl-10 pr-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-full shadow-md focus:ring-blue-500 focus:border-blue-500"
                x-on:keydown.enter="applySearchFilter()"
                placeholder="Cari mahasiswa...">
        </div>
    </div>

    <!-- Alert Messages -->
    <div id="alertContainer" class="hidden border-l-4 p-4 mb-6" role="alert">
        <p id="alertMessage"></p>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <x-dropdown align="left">
            <x-slot name="trigger">
                <button
                    class="w-full md:w-48 text-gray-700 bg-white hover:bg-gray-100 border border-gray-300 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center justify-between shadow-md">
                    <div>{{ request('angkatan', 'Semua Angkatan') }}</div>

                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content">
                <ul class="py-2 text-sm text-gray-700">
                    <li>
                        <a href="{{ route('admin.mahasiswa')}}" x-on:click.prevent="filterByAngkatan('all')"; return false;"
                            class="block px-4 py-2 hover:bg-gray-100">Semua Angkatan</a>
                    </li>
                    @foreach ($allAngkatan as $year)
                    <li>
                        <a href="#" x-on:click.prevent="filterByAngkatan('{{ $year }}')"
                            class="block px-4 py-2 hover:bg-gray-100">{{ $year }}</a>
                    </li>
                @endforeach
                </ul>
            </x-slot>
        </x-dropdown>
        <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
            <button
                class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:ring-lime-300 font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center"
                x-on:click="$dispatch('open-modal', 'tambahMahasiswaModal')">
                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Mahasiswa
            </button>
        </div>
    </div>


    <!-- Table Section -->
    <div class="overflow-x-auto shadow-xl rounded-lg bg-white">
        <table class="w-full text-sm text-left text-gray-800">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                <tr>
                    <th scope="col" class="px-6 py-4">NIM</th>
                    <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                    <th scope="col" class="px-6 py-4">Email</th>
                    <th scope="col" class="px-6 py-4">Program Studi</th>
                    <th scope="col" class="px-6 py-4">Angkatan</th>
                    <th scope="col" class="px-6 py-4">No Telepon</th>
                    <th scope="col" class="px-6 py-4 text-center">Progress</th>
                    <th scope="col" class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody id="mahasiswa-table-body">
                @forelse ($mahasiswa as $mhs)
                <tr class="bg-white hover:bg-gray-50 border-b mahasiswa-row" data-angkatan="{{ $mhs->angkatan }}">
                    <td class="px-6 py-4 font-medium">{{ $mhs->nim }}</td>
                    <td class="px-6 py-4">{{ $mhs->nama_lengkap }}</td>
                    <td class="px-6 py-4">{{ $mhs->user->email }}</td>
                    <td class="px-6 py-4">{{ $mhs->program_studi }}</td>
                    <td class="px-6 py-4">{{ $mhs->angkatan }}</td>
                    <td class="px-6 py-4">{{ $mhs->no_hp }}</td>
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
                    <td class="px-6 py-4">
                        <button type="button"
                            x-on:click="openModal('editMahasiswaModal',{{ json_encode($mhs) }})"
                            class="bg-[#FBDA00] text-white hover:bg-yellow-300 border border-transparent focus:ring-4 focus:ring-[#FBDA00]-300 rounded-lg p-2"
                            title="Edit">
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                           </button>
                    </td>
                </tr>
                @empty
                <tr class="bg-white hover:bg-gray-50 border-b">
                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data mahasiswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<x-modal name="tambahMahasiswaModal">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                Tambah Mahasiswa
            </h3>
            <button type="button" x-on:click="closeModal()"
                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Tutup</span>
            </button>
        </div>
        <!-- Modal body -->
        <form id="mahasiswaForm" action="{{ route('admin.mahasiswa.create') }}" method="POST">
            @csrf
            <div class="p-4 md:p-5 space-y-4 max-h-[60vh] overflow-y-auto">
                <!-- Nama Lengkap -->
                <div>
                    <label for="nama_lengkap"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan nama lengkap" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Email</label>
                    <input type="email" name="email" id="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label for="nim"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">NIM</label>
                    <input type="text" name="nim" id="nim"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan NIM" value="{{ old('nim') }}" required>
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Studi -->
                <div>
                    <label for="program_studi"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Program Studi</label>
                    <input type="text" name="program_studi" id="program_studi" value="Sistem Informasi"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan program studi" value="{{ old('program_studi') }}" required>
                    @error('program_studi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Angkatan -->
                <div>
                    <label for="angkatan"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Angkatan</label>
                    <input type="text" name="angkatan" id="angkatan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan angkatan (contoh: 2023)" value="{{ old('angkatan') }}" required>
                    @error('angkatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="no_hp"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">No HP</label>
                    <input type="text" name="no_hp" id="no_hp"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan nomor HP" value="{{ old('no_hp') }}" required>
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Password</label>
                    <input type="password" name="password" id="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan password" required>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Konfirmasi password" required>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit"
                    class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                <button type="button" x-on:click="closeModal('tambahMahasiswaModal')"
                    class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
            </div>
        </form>
    </div>
</x-modal>

<x-modal name="editMahasiswaModal">
    <!-- Modal content -->
    <div class="relative bg-white rounded-lg shadow dark:bg-[#FFFDF6]-700">
        <!-- Modal header -->
        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-black">
                Edit Mahasiswa
            </h3>
            <button type="button" x-on:click="closeModal()"
                class="end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Tutup</span>
            </button>
        </div>
        <!-- Modal body -->
        <form id="editmahasiswaForm" action="{{ route('admin.mahasiswa.update') }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" x-model="user?.id" name="mahasiswa_id" id="mahasiswa_id">
            <div class="p-4 md:p-5 space-y-4 max-h-[60vh] overflow-y-auto">
                <!-- Nama Lengkap -->
                <div>
                    <label for="edit_nama_lengkap"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Nama Lengkap</label>
                    <input x-model="user?.nama_lengkap" type="text" name="nama_lengkap" id="nama_lengkap"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan nama lengkap" required>
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="edit_email"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Email</label>
                    <input x-model="user?.user?.email" type="email" name="email" id="edit_email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan email" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- NIM -->
                <div>
                    <label for="edit_nim"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">NIM</label>
                    <input x-model="user?.nim" type="text" name="nim" id="edit_nim"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan NIM" required>
                    @error('nim')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Studi -->
                <div>
                    <label for="edit_program_studi"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Program Studi</label>
                    <input x-model="user?.program_studi" type="text" name="program_studi" id="edit_program_studi"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan program studi"  required>
                    @error('program_studi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Angkatan -->
                <div>
                    <label for="edit_angkatan"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">Angkatan</label>
                    <input x-model="user?.angkatan" type="text" name="angkatan" id="edit_angkatan"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan angkatan (contoh: 2023)"required>
                    @error('angkatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No HP -->
                <div>
                    <label for="edit_no_hp"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-black">No HP</label>
                    <input x-model="user?.no_hp" type="text" name="no_hp" id="no_hp"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-600 dark:border-black-500 dark:placeholder-gray-400 dark:text-black"
                        placeholder="Masukkan nomor HP" required>
                    @error('no_hp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button type="submit"
                    class="text-white bg-[#638B35] hover:bg-lime-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
                <button type="button" x-on:click="closeModal('tambahMahasiswaModal')"
                    class="ms-3 text-black-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-300 dark:text-black-300 dark:border-gray-300 dark:hover:text-black dark:hover:bg-gray-400 dark:focus:ring-gray-600">Batal</button>
            </div>
        </form>
    </div>
</x-modal>
</div>
@endsection
