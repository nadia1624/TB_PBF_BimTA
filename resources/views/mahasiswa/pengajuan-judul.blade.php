<x-app-layout>
    <div class="w-full bg-gray-100 py-8 px-4">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 md:p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Pengajuan Judul Tugas Akhir</h2>

            @if ($errors->any())
            <div class="bg-red-50 text-red-700 p-4 rounded-md mb-6 border border-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-50 text-red-700 p-4 rounded-md mb-6 border border-red-200">
                <p>{{ session('error') }}</p>
            </div>
            @endif

            @if(session('success'))
            <div class="bg-green-50 text-green-700 p-4 rounded-md mb-6 border border-green-200">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(isset($isDataComplete) && !$isDataComplete)
            <div class="bg-yellow-50 text-yellow-700 p-4 rounded-md mb-6 border border-yellow-200">
                <p>Perhatian! Data mahasiswa Anda belum lengkap. Silakan lengkapi profil Anda terlebih dahulu sebelum mengajukan judul.</p>
                <a href="{{ route('profile.edit') }}" class="mt-2 inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                    Lengkapi Data Mahasiswa
                </a>
            </div>
            @endif

            @if(isset($pengajuan))
                <!-- Display submission status based on status -->
                <div class="mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">
                        <div>
                            <h3 class="font-medium text-gray-800">Judul Tugas Akhir</h3>
                            <p class="text-gray-600">{{ $pengajuan->judul }}</p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Status</h3>
                            @php
                                $detailDosen = $pengajuan->detailDosen()->first();
                                $status = $detailDosen ? $detailDosen->status : 'diproses';
                                $rejectedBy = null;

                                // Check which pembimbing rejected (if rejected)
                                if ($status == 'ditolak') {
                                    foreach ($pengajuan->detailDosen as $detail) {
                                        if ($detail->status == 'ditolak') {
                                            $rejectedBy = $detail->pembimbing;
                                            break;
                                        }
                                    }
                                }
                            @endphp

                            @if($status == 'diproses')
                                <span class="px-3 py-1 bg-yellow-200 text-yellow-800 rounded-full text-xs font-medium">Diproses</span>
                            @elseif($status == 'diterima')
                                <span class="px-3 py-1 bg-green-200 text-green-800 rounded-full text-xs font-medium">Diterima</span>
                            @elseif($status == 'ditolak')
                                <span class="px-3 py-1 bg-red-200 text-red-800 rounded-full text-xs font-medium">Ditolak oleh dosen {{ $rejectedBy }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">
                        <div>
                            <h3 class="font-medium text-gray-800">Dosen Pembimbing 1</h3>
                            <p class="text-gray-600">
                                @foreach($dosenList as $dosen)
                                    @if($dosen->id == $pembimbing1)
                                        {{ $dosen->nama_lengkap }}
                                    @endif
                                @endforeach
                            </p>
                        </div>
                        <div>
                            <h3 class="font-medium text-gray-800">Dosen Pembimbing 2</h3>
                            <p class="text-gray-600">
                                @if($pembimbing2)
                                    @foreach($dosenList as $dosen)
                                        @if($dosen->id == $pembimbing2)
                                            {{ $dosen->nama_lengkap }}
                                        @endif
                                    @endforeach
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Status-specific messages -->
                    @if($status == 'diproses')
                        <div class="bg-yellow-50 p-4 border border-yellow-200 rounded-md">
                            <h4 class="font-medium text-yellow-800 mb-1">Pengajuan Dalam Proses</h4>
                            <p class="text-yellow-700">Anda sudah mengajukan judul dan masih dalam proses review. Silakan tunggu respons dari dosen pembimbing atau hubungi admin jika diperlukan.</p>
                        </div>
                    @elseif($status == 'diterima')
                        <div class="bg-green-50 p-4 border border-green-200 rounded-md">
                            <h4 class="font-medium text-green-800 mb-1">Pengajuan Disetujui</h4>
                            <p class="text-green-700">Anda sudah mengajukan judul dan sudah disetujui oleh dosen pembimbing</p>
                        </div>
                    @elseif($status == 'ditolak')
                        <div class="bg-red-50 p-4 border border-red-200 rounded-md">
                            <h4 class="font-medium text-red-800 mb-1">Pengajuan Ditolak</h4>
                            <p class="text-red-700">Judul tugas akhir anda ditolak/anda sudah tidak menjadi mahasiswa bimbingan
                                @php
                                    $rejectedDetail = $pengajuan->detailDosen->where('status', 'ditolak')->first();
                                    $rejectedDosenId = $rejectedDetail ? $rejectedDetail->dosen_id : null;
                                @endphp
                                @foreach($dosenList as $dosen)
                                    @if($dosen->id == $rejectedDosenId)
                                        {{ $dosen->nama_lengkap }}
                                    @endif
                                @endforeach
                            </p>
                            @php
                                $rejectedDetail = $pengajuan->detailDosen->where('status', 'ditolak')->first();
                                $alasanDitolak = $rejectedDetail ? $rejectedDetail->alasan_dibatalkan : null;
                            @endphp
                            @if($alasanDitolak)
                                <p class="text-red-700 mt-2">Alasan: {{ $alasanDitolak }}</p>
                            @else
                                <p class="text-red-700 mt-2">[Alasan ditolak/dibatalkan]</p>
                            @endif
                        </div>

                        <div class="flex justify-end mt-4">
                            <a href="{{ route('pengajuan-judul.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Ajukan Kembali
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <!-- Show form for new submission -->
                <form action="{{ route('pengajuan-judul.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Form content remains the same... -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <div>
                                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas Akhir</label>
                                <input
                                    type="text"
                                    id="judul"
                                    name="judul"
                                    value="{{ old('judul') }}"
                                    placeholder="Masukkan judul tugas akhir"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                    required
                                >
                            </div>

                            <div>
                                <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi/Abstrak</label>
                                <textarea
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    placeholder="Jelaskan secara singkat tentang apa yang akan dilakukan"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                    required
                                >{{ old('deskripsi') }}</textarea>
                            </div>

                            <div>
                                <label for="tanda_tangan" class="block text-sm font-medium text-gray-700 mb-1">Unggah Tanda Tangan</label>
                                <div class="flex">
                                    <label for="tanda_tangan" class="w-full flex items-center">
                                        <input
                                            type="text"
                                            readonly
                                            id="file_name"
                                            class="w-full border border-gray-300 bg-gray-50 rounded-l px-3 py-2"
                                            placeholder="Tidak ada file yang dipilih"
                                        >
                                        <span class="bg-white border border-gray-300 border-l-0 rounded-r px-4 py-2 inline-flex items-center text-sm text-gray-700 hover:bg-gray-50 cursor-pointer">
                                            Upload
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                        </span>
                                    </label>
                                    <input
                                        type="file"
                                        id="tanda_tangan"
                                        name="tanda_tangan"
                                        class="hidden"
                                        accept=".jpg,.jpeg,.png,.pdf"
                                        required
                                        onchange="document.getElementById('file_name').value = this.files[0].name"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG, PDF. Maksimal ukuran: 2MB</p>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <div>
                                <label for="dosen_pembimbing1" class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing 1</label>
                                <div class="relative">
                                    <select
                                        id="dosen_pembimbing1"
                                        name="dosen_pembimbing1"
                                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white appearance-none focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                        required
                                    >
                                        <option value="" disabled {{ old('dosen_pembimbing1') ? '' : 'selected' }}>Pilih Pembimbing 1</option>
                                        @foreach ($dosenList as $dosen)
                                            <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing1') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="dosen_pembimbing2" class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing 2 (Opsional)</label>
                                <div class="relative">
                                    <select
                                        id="dosen_pembimbing2"
                                        name="dosen_pembimbing2"
                                        class="w-full border border-gray-300 rounded px-3 py-2 bg-white appearance-none focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                    >
                                        <option value="" {{ old('dosen_pembimbing2') ? '' : 'selected' }}>Pilih Pembimbing 2</option>
                                        @foreach ($dosenList as $dosen)
                                            <option value="{{ $dosen->id }}" {{ old('dosen_pembimbing2') == $dosen->id ? 'selected' : '' }}>
                                                {{ $dosen->nama_lengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer dengan tombol -->
                    <div class="flex justify-end mt-6 space-x-3">
                        <button
                            type="reset"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400"
                        >
                            Reset Form
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
                        >
                            Ajukan Judul
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
