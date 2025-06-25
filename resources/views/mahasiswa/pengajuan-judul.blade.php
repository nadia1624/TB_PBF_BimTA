@extends('layouts.app')

@section('content')
    <div class="w-full bg-gray-100 py-8 px-4 space-y-6">
        <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 md:p-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Daftar Dosen</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($dosenList as $dosen)
                    <div class="border rounded-lg overflow-hidden shadow-sm">
                        <div class="bg-gray-300 h-40">
                            <div class="h-full w-full bg-gray-200 flex items-center justify-center overflow-hidden border-2">
                                @if($dosen->gambar)
                                    <img src="{{ asset('storage/' . $dosen->gambar) }}" alt="Profile image" class="h-full w-full object-cover">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 space-y-2">
                            <h3 class="font-semibold text-gray-800">{{ $dosen->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-600">{{ $dosen->nip }}</p>
                            <p class="text-sm text-gray-600">Bidang Keahlian :
                                @if ($dosen->detailBidang->isNotEmpty())
                                    <ul class="list-disc list-inside ml-4">
                                        @foreach ($dosen->detailBidang as $bidang)
                                            <li class="text-sm text-gray-600">{{ optional($bidang->bidangKeahlian)->nama_keahlian ?? 'Belum ditentukan' }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-yellow-500">Belum ditentukan</span>
                                @endif
                            </p>
                            {{-- <div class="mt-2 flex items-center">
                                <p class="text-sm text-gray-600 mr-2">Kuota Tersedia :</p>
                                <p class="text-lg font-bold text-gray-700">20</p>
                            </div> --}}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

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

            @if(isset($isData) && !$isData)
                <div class="bg-yellow-50 text-yellow-700 p-4 rounded-md mb-6 border border-yellow-200">
                    <p>Perhatian! Data mahasiswa Anda belum lengkap. Silakan lengkapi profil Anda terlebih dahulu sebelum mengajukan judul.</p>
                    <a href="{{ route('profile.edit') }}" class="mt-2 inline-block px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Lengkapkan Data Mahasiswa
                    </a>
                </div>
            @else
                {{-- Bagian untuk menampilkan semua riwayat pengajuan --}}
                @if($allPengajuan->isNotEmpty())
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pengajuan Judul</h3>
                    <div class="space-y-4 mb-8">
                        @foreach($allPengajuan as $pengajuanItem)
                            <div class="border rounded-lg shadow-sm p-4 {{ $pengajuan && $pengajuan->id === $pengajuanItem->id ? 'border-blue-500 bg-blue-50' : 'bg-gray-50' }}">
                                <p class="font-medium text-gray-700">Judul: {{ $pengajuanItem->judul }}</p>
                                <p class="text-sm text-gray-600">Diajukan: {{ $pengajuanItem->created_at->format('d M Y H:i') }}</p>
                                <p class="text-sm text-gray-600">Deskripsi: {{ Str::limit($pengajuanItem->deskripsi, 100) }}</p>
                                @php
                                    $itemP1 = $pengajuanItem->detailDosen->where('pembimbing', 'pembimbing 1')->first();
                                    $itemP2 = $pengajuanItem->detailDosen->where('pembimbing', 'pembimbing 2')->first();
                                    $itemStatusColor = 'yellow';
                                    $itemStatusText = 'Diproses';

                                    if (($itemP1 && $itemP1->status === 'ditolak') && ($itemP2 && $itemP2->status === 'ditolak')) {
                                        $itemStatusColor = 'red';
                                        $itemStatusText = 'Ditolak (Keduanya)';
                                    } elseif (($itemP1 && $itemP1->status === 'ditolak') || ($itemP2 && $itemP2->status === 'ditolak')) {
                                        $itemStatusColor = 'red';
                                        $itemStatusText = 'Ditolak';
                                    } elseif (($itemP1 && $itemP1->status === 'diterima') && (!$itemP2 || ($itemP2 && $itemP2->status === 'diterima'))) {
                                        $itemStatusColor = 'green';
                                        $itemStatusText = 'Diterima';
                                    }
                                @endphp
                                <p class="text-sm text-gray-600">Status: <span class="px-2 py-0.5 bg-{{$itemStatusColor}}-200 text-{{$itemStatusColor}}-800 rounded-full text-xs font-medium">{{ $itemStatusText }}</span></p>
                                <ul class="list-disc list-inside text-sm text-gray-600 ml-4">
                                    <li>Pembimbing 1: {{ optional($itemP1->dosen)->nama_lengkap ?? 'Belum ditentukan' }} (Status: {{ $itemP1->status ?? 'N/A' }})</li>
                                    @if($itemP2)
                                        <li>Pembimbing 2: {{ optional($itemP2->dosen)->nama_lengkap ?? 'Belum ditentukan' }} (Status: {{ $itemP2->status ?? 'N/A' }})</li>
                                    @else
                                        <li>Pembimbing 2: -</li>
                                    @endif
                                </ul>
                                @if($pengajuan && $pengajuan->id === $pengajuanItem->id)
                                    <p class="text-xs text-blue-600 mt-2">Ini adalah pengajuan terakhir Anda.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 mb-8">Anda belum memiliki riwayat pengajuan judul.</p>
                @endif

                {{-- Bagian Aksi untuk Pengajuan TERAKHIR (jika ada) --}}
                @if($pengajuan)
                    <div class="mb-6 border-t pt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pengajuan Terakhir Anda</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">
                            <div>
                                <h3 class="font-medium text-gray-800">Judul Tugas Akhir</h3>
                                <p class="text-gray-600">{{ $pengajuan->judul }}</p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Status</h3>
                                <span class="px-3 py-1 bg-{{$statusColor}}-200 text-{{$statusColor}}-800 rounded-full text-xs font-medium">{{ $overallStatusText }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4 mb-4">
                            <div>
                                <h3 class="font-medium text-gray-800">Dosen Pembimbing 1</h3>
                                <p class="text-gray-600">
                                    {{ $dosenList->find($pembimbing1)->nama_lengkap ?? 'Belum ditentukan' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-800">Dosen Pembimbing 2</h3>
                                <p class="text-gray-600">
                                    @if($pembimbing2)
                                        {{ $dosenList->find($pembimbing2)->nama_lengkap ?? 'Belum ditentukan' }}
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="action-area">
                            <div class="bg-{{$statusColor}}-50 p-4 border border-{{$statusColor}}-200 rounded-md">
                                <h4 class="font-medium text-{{$statusColor}}-800 mb-1">{{ $overallStatusText }}</h4>
                                <p class="text-{{$statusColor}}-700">{{ $statusMessage }}</p>

                                {{-- Display specific rejection reasons if applicable and $rejectedDetailDosen is available --}}
                                @if($rejectedDetailDosen && $rejectedDetailDosen->alasan_dibatalkan && $overallStatusText !== 'Ditolak oleh Kedua Dosen Pembimbing')
                                    <p class="text-{{$statusColor}}-700 mt-2">Alasan: {{ $rejectedDetailDosen->alasan_dibatalkan }}</p>
                                @endif

                                <div class="mt-4 space-y-2">
                                    {{-- Define action buttons based on overallStatusText and specific conditions --}}
                                    @php
                                        $p1 = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 1')->first();
                                        $p2 = $pengajuan->detailDosen->where('pembimbing', 'pembimbing 2')->first();

                                        $p1Rejected = $p1 && $p1->status === 'ditolak';
                                        $p2Rejected = $p2 && $p2->status === 'ditolak';
                                        $p1Accepted = $p1 && $p1->status === 'diterima';
                                        $p2Accepted = $p2 && $p2->status === 'diterima';
                                    @endphp

                                    @if($overallStatusText === 'Ditolak oleh Kedua Dosen Pembimbing')
                                        <form action="{{ route('mahasiswa.pengajuan-judul.destroy', $pengajuan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Riwayat pengajuan akan dihapus.')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Batalkan Pengajuan
                                            </button>
                                        </form>
                                        <button data-action="resubmit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Ajukan Judul BARU (dengan data ini)
                                        </button>
                                    @elseif($p1Rejected && $p2Accepted)
                                        <button data-action="replace-advisor1" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Ganti Dosen Pembimbing 1
                                        </button>
                                        {{-- <button data-action="promote-advisor" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            Jadikan Dosen Pembimbing 2 sebagai Pembimbing 1
                                        </button> --}}
                                        <form action="{{ route('mahasiswa.pengajuan-judul.destroy', $pengajuan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Riwayat pengajuan akan dihapus.')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Batalkan Pengajuan
                                            </button>
                                        </form>
                                    @elseif($p2Rejected && $p1Accepted)
                                        <button data-action="replace-advisor2" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Ganti Dosen Pembimbing 2
                                        </button>
                                        <button data-action="remove-advisor2" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                            Tidak Gunakan Dosen Pembimbing 2
                                        </button>
                                    @elseif(($p1Rejected || $p2Rejected) && !($p1Accepted && ($p2Accepted || !$p2))) {{-- If any rejected but not fully accepted --}}
                                        <form action="{{ route('mahasiswa.pengajuan-judul.destroy', $pengajuan->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini? Riwayat pengajuan akan dihapus.')" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Batalkan Pengajuan
                                            </button>
                                        </form>
                                        <button data-action="resubmit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Ajukan Judul BARU (dengan data ini)
                                        </button>
                                    @elseif($overallStatusText === 'Diterima')
                                        {{-- <button data-action="new-submission" class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
                                            Ajukan Judul Lain (Baru)
                                        </button> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-gray-600">Anda belum memiliki pengajuan judul. Silakan ajukan judul tugas akhir Anda.</p>
                @endif

                <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-md p-6 md:p-8 mt-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6">
                        @if($action === 'resubmit' || $action === 'new-submission')
                            Form Pengajuan Judul Baru
                        @else
                            Form Perubahan Pengajuan Judul
                        @endif
                    </h2>
                    <div id="submission-form" class="mt-4 @if(!$displayForm) hidden @endif">
                        {{-- Determine the form action and method based on current state and `action` --}}
                        <form action="{{ route('mahasiswa.pengajuan-judul.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="action" id="form-action" value="{{ old('action', $action ?? '') }}">
                            {{-- <input type="hidden" name="advisor_type" id="advisor-type" value=""> Remove this, not used --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                                <div class="space-y-4">
                                    <div>
                                        <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Tugas Akhir</label>
                                        <input
                                            type="text"
                                            id="judul"
                                            name="judul"
                                            value="{{ old('judul', ($pengajuan && ($action !== 'new-submission') ? $pengajuan->judul : '') ) }}"
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
                                        >{{ old('deskripsi', ($pengajuan && ($action !== 'new-submission') ? $pengajuan->deskripsi : '') ) }}</textarea>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    {{-- Provide clearer messages based on action --}}
                                    @if ($action === 'resubmit' || $action === 'new-submission')
                                        <p class="text-yellow-700 mt-2 mb-4">Silakan pilih dosen pembimbing baru untuk pengajuan ini.</p>
                                    @elseif ($action === 'replace-advisor1')
                                        <p class="text-yellow-700 mt-2 mb-4">Silakan pilih Dosen Pembimbing 1 yang baru.</p>
                                    @elseif ($action === 'replace-advisor2')
                                        <p class="text-yellow-700 mt-2 mb-4">Silakan pilih Dosen Pembimbing 2 yang baru.</p>
                                    @endif

                                    {{-- Dosen Pembimbing 1 field --}}
                                    <div id="advisor1-field" class="advisor-field">
                                        <label for="dosen_pembimbing1" class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing 1</label>
                                        <div class="relative">
                                            <select
                                                id="dosen_pembimbing1"
                                                name="dosen_pembimbing1"
                                                class="w-full border border-gray-300 rounded px-3 py-2 bg-white appearance-none focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                                required
                                            >
                                                <option value="" disabled {{ old('dosen_pembimbing1', $pembimbing1 ?? '') ? '' : 'selected' }}>Pilih Pembimbing 1</option>
                                                @foreach ($dosenList as $dosen)
                                                    @php
                                                        $isDisabled = false;
                                                        // Disable rejected advisor for resubmit or specific replacement
                                                        if (is_array($rejectedDosenId)) { // Both rejected
                                                            if (in_array($dosen->id, $rejectedDosenId) && ($action === 'resubmit' || $action === 'new-submission')) {
                                                                $isDisabled = true;
                                                            }
                                                        } elseif ($dosen->id == $rejectedDosenId && ($action === 'resubmit' || $action === 'new-submission' || ($action === 'replace-advisor1' && $rejectedBy === 'pembimbing 1') )) {
                                                            $isDisabled = true;
                                                        }
                                                        // Prevent selecting current P2 if promoting (handled by JS)
                                                        if ($action === 'promote-advisor' && $dosen->id == $pembimbing2) {
                                                            $isDisabled = true; // This will be handled by promoting P2's ID to P1's
                                                        }
                                                    @endphp
                                                    <option value="{{ $dosen->id }}"
                                                        {{ old('dosen_pembimbing1', $pembimbing1 ?? '') == $dosen->id && $action !== 'resubmit' && $action !== 'new-submission' && $action !== 'promote-advisor' ? 'selected' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}
                                                        >
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
                                    {{-- Dosen Pembimbing 2 field --}}
                                    <div id="advisor2-field" class="advisor-field">
                                        <label for="dosen_pembimbing2" class="block text-sm font-medium text-gray-700 mb-1">Dosen Pembimbing 2 (Opsional)</label>
                                        <div class="relative">
                                            <select
                                                id="dosen_pembimbing2"
                                                name="dosen_pembimbing2"
                                                class="w-full border border-gray-300 rounded px-3 py-2 bg-white appearance-none focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500"
                                            >
                                                <option value="" {{ old('dosen_pembimbing2', $pembimbing2 ?? '') ? '' : 'selected' }}>Pilih Pembimbing 2</option>
                                                @foreach ($dosenList as $dosen)
                                                    @php
                                                        $isDisabled = false;
                                                        if (is_array($rejectedDosenId)) { // Both rejected
                                                            if (in_array($dosen->id, $rejectedDosenId) && ($action === 'resubmit' || $action === 'new-submission')) {
                                                                $isDisabled = true;
                                                            }
                                                        } elseif ($dosen->id == $rejectedDosenId && ($action === 'resubmit' || $action === 'new-submission' || ($action === 'replace-advisor2' && $rejectedBy === 'pembimbing 2'))) {
                                                            $isDisabled = true;
                                                        }
                                                    @endphp
                                                    <option value="{{ $dosen->id }}"
                                                        {{ old('dosen_pembimbing2', $pembimbing2 ?? '') == $dosen->id && $action !== 'resubmit' && $action !== 'new-submission' ? 'selected' : '' }}
                                                        {{ $isDisabled ? 'disabled' : '' }}
                                                        >
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
                                    @if($action === 'resubmit' || $action === 'new-submission')
                                        Ajukan Judul
                                    @else
                                        Perbarui Pengajuan
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('submission-form');
        const actionInput = document.getElementById('form-action');
        const advisor1Field = document.getElementById('advisor1-field');
        const advisor2Field = document.getElementById('advisor2-field');
        const dosenPembimbing1Select = document.getElementById('dosen_pembimbing1');
        const dosenPembimbing2Select = document.getElementById('dosen_pembimbing2');
        const buttons = document.querySelectorAll('.action-area button[data-action]');

        const judulInput = document.getElementById('judul');
        const deskripsiInput = document.getElementById('deskripsi');

        // Initial state from PHP
        const phpPengajuan = @json($pengajuan);
        const phpPembimbing1 = {{ $pembimbing1 ?? 'null' }};
        const phpPembimbing2 = {{ $pembimbing2 ?? 'null' }};
        const phpRejectedDosenId = @json($rejectedDosenId);
        const phpRejectedBy = '{{ $rejectedBy ?? '' }}';
        const phpAction = '{{ $action ?? '' }}';
        const phpDisplayForm = {{ $displayForm ? 'true' : 'false' }};

        function resetFormVisibilityAndRequirements() {
            form.classList.remove('hidden'); // Ensure form is visible by default for any action
            advisor1Field.classList.remove('hidden');
            advisor2Field.classList.remove('hidden');
            dosenPembimbing1Select.required = true;
            dosenPembimbing2Select.required = false;

            // Enable all options first
            [dosenPembimbing1Select, dosenPembimbing2Select].forEach(select => {
                Array.from(select.options).forEach(option => {
                    option.disabled = false;
                });
            });

            // Reset selected values (important for 'new-submission' and 'resubmit')
            dosenPembimbing1Select.value = '';
            dosenPembimbing2Select.value = '';
        }

        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const action = this.getAttribute('data-action');
                resetFormVisibilityAndRequirements(); // Reset everything first
                actionInput.value = action; // Set the hidden action field

                // Logic based on action
                if (action === 'replace-advisor1') {
                    judulInput.value = phpPengajuan.judul;
                    deskripsiInput.value = phpPengajuan.deskripsi;
                    dosenPembimbing1Select.value = ''; // Clear P1 selection for replacement
                    dosenPembimbing2Select.value = phpPembimbing2; // Keep P2 as is

                    advisor2Field.classList.remove('hidden'); // Ensure P2 is visible
                    dosenPembimbing1Select.required = true;
                    dosenPembimbing2Select.required = false;

                    // Disable the rejected P1 if it's the specific case
                    if (phpRejectedDosenId === phpPembimbing1 && phpRejectedBy === 'pembimbing 1') {
                        Array.from(dosenPembimbing1Select.options).forEach(option => {
                            if (option.value == phpRejectedDosenId) {
                                option.disabled = true;
                            }
                        });
                    }

                } else if (action === 'promote-advisor') {
                    // Title and Description remain the same
                    judulInput.value = phpPengajuan.judul;
                    deskripsiInput.value = phpPengajuan.deskripsi;

                    // This action will be handled entirely in the backend (Controller)
                    // The form will essentially just "trigger" the backend change.
                    // So we can hide the advisor fields or set their values to what they will become.
                    advisor1Field.classList.add('hidden'); // Hide P1 field, it will be auto-set by backend
                    advisor2Field.classList.add('hidden'); // Hide P2 field, it will be auto-set by backend
                    dosenPembimbing1Select.required = false;
                    dosenPembimbing2Select.required = false;

                    // This makes the submit button in the form "trigger" the backend promote-advisor logic.
                    // We need a way to submit the form with this action.
                    // For now, let's just show a message or confirm the action via an alert/modal.
                    // A direct form submission is better.
                    // Set dummy values if fields are required by backend but hidden.
                    dosenPembimbing1Select.value = phpPembimbing2; // Visually set P1 to P2
                    dosenPembimbing2Select.value = ''; // Clear P2
                    // You might want a simpler form submission for these specific actions.
                    // For now, setting the input fields like this is a workaround.

                } else if (action === 'replace-advisor2') {
                    judulInput.value = phpPengajuan.judul;
                    deskripsiInput.value = phpPengajuan.deskripsi;
                    dosenPembimbing1Select.value = phpPembimbing1; // Keep P1 as is
                    dosenPembimbing2Select.value = ''; // Clear P2 selection for replacement

                    advisor1Field.classList.remove('hidden'); // Ensure P1 is visible
                    dosenPembimbing1Select.required = true;
                    dosenPembimbing2Select.required = false; // P2 is optional

                    // Disable the rejected P2 if it's the specific case
                    if (phpRejectedDosenId === phpPembimbing2 && phpRejectedBy === 'pembimbing 2') {
                        Array.from(dosenPembimbing2Select.options).forEach(option => {
                            if (option.value == phpRejectedDosenId) {
                                option.disabled = true;
                            }
                        });
                    }

                } else if (action === 'remove-advisor2') {
                    judulInput.value = phpPengajuan.judul;
                    deskripsiInput.value = phpPengajuan.deskripsi;
                    dosenPembimbing1Select.value = phpPembimbing1; // Keep P1 as is
                    dosenPembimbing2Select.value = ''; // Clear P2 selection

                    advisor1Field.classList.remove('hidden');
                    advisor2Field.classList.add('hidden'); // Hide P2 field
                    dosenPembimbing1Select.required = true;
                    dosenPembimbing2Select.required = false; // Not required as it's being removed

                } else if (action === 'resubmit') {
                    // For resubmit, use existing title/description but clear advisor selections
                    judulInput.value = phpPengajuan.judul;
                    deskripsiInput.value = phpPengajuan.deskripsi;
                    dosenPembimbing1Select.value = '';
                    dosenPembimbing2Select.value = '';

                    advisor1Field.classList.remove('hidden');
                    advisor2Field.classList.remove('hidden');
                    dosenPembimbing1Select.required = true;
                    dosenPembimbing2Select.required = false;

                    // Disable previously rejected advisors from both lists
                    // If phpRejectedDosenId is an array (both rejected)
                    if (Array.isArray(phpRejectedDosenId)) {
                        [dosenPembimbing1Select, dosenPembimbing2Select].forEach(select => {
                            Array.from(select.options).forEach(option => {
                                if (phpRejectedDosenId.includes(parseInt(option.value))) {
                                    option.disabled = true;
                                }
                            });
                        });
                    } else if (phpRejectedDosenId) { // Single rejected advisor
                        [dosenPembimbing1Select, dosenPembimbing2Select].forEach(select => {
                            Array.from(select.options).forEach(option => {
                                if (option.value == phpRejectedDosenId) {
                                    option.disabled = true;
                                }
                            });
                        });
                    }

                } else if (action === 'new-submission') {
                    // Clear all fields for a completely new submission
                    judulInput.value = '';
                    deskripsiInput.value = '';
                    dosenPembimbing1Select.value = '';
                    dosenPembimbing2Select.value = '';

                    advisor1Field.classList.remove('hidden');
                    advisor2Field.classList.remove('hidden');
                    dosenPembimbing1Select.required = true;
                    dosenPembimbing2Select.required = false;
                }

                form.scrollIntoView({ behavior: 'smooth' });
            });
        });

        // Initial form display logic on page load
        if (!phpDisplayForm) {
            form.classList.add('hidden');
        } else {
            // Reapply disabled status for advisors based on initial page load state
            if (phpRejectedDosenId) {
                if (Array.isArray(phpRejectedDosenId)) {
                    [dosenPembimbing1Select, dosenPembimbing2Select].forEach(select => {
                        Array.from(select.options).forEach(option => {
                            if (phpRejectedDosenId.includes(parseInt(option.value))) {
                                option.disabled = true;
                            }
                        });
                    });
                } else {
                    if (phpRejectedBy === 'pembimbing 1' || phpAction === 'resubmit' || phpAction === 'new-submission') {
                        Array.from(dosenPembimbing1Select.options).forEach(option => {
                            if (option.value == phpRejectedDosenId) {
                                option.disabled = true;
                            }
                        });
                    }
                    if (phpRejectedBy === 'pembimbing 2' || phpAction === 'resubmit' || phpAction === 'new-submission') {
                        Array.from(dosenPembimbing2Select.options).forEach(option => {
                            if (option.value == phpRejectedDosenId) {
                                option.disabled = true;
                            }
                        });
                    }
                }
            }

            // Set initial form values based on whether it's a "new-submission" or editing existing.
            // If action is 'resubmit' or 'new-submission', clear advisor fields even if pengajuan exists.
            if (phpPengajuan && (phpAction !== 'resubmit' && phpAction !== 'new-submission')) {
                judulInput.value = phpPengajuan.judul;
                deskripsiInput.value = phpPengajuan.deskripsi;
                dosenPembimbing1Select.value = phpPembimbing1;
                dosenPembimbing2Select.value = phpPembimbing2;
            } else { // For new submission or resubmit, clear the fields
                judulInput.value = phpPengajuan ? phpPengajuan.judul : ''; // Keep title/desc for resubmit
                deskripsiInput.value = phpPengajuan ? phpPengajuan.deskripsi : '';
                dosenPembimbing1Select.value = '';
                dosenPembimbing2Select.value = '';
            }
        }

        // Handle the "Reset Form" button
        document.querySelector('button[type="reset"]').addEventListener('click', function() {
            // Revert to initial state on page load (if any proposal exists)
            resetFormVisibilityAndRequirements();
            if (phpPengajuan && (phpAction !== 'resubmit' && phpAction !== 'new-submission')) {
                judulInput.value = phpPengajuan.judul;
                deskripsiInput.value = phpPengajuan.deskripsi;
                dosenPembimbing1Select.value = phpPembimbing1;
                dosenPembimbing2Select.value = phpPembimbing2;
            } else {
                judulInput.value = '';
                deskripsiInput.value = '';
                dosenPembimbing1Select.value = '';
                dosenPembimbing2Select.value = '';
            }
            actionInput.value = ''; // Clear action on reset
            if (!phpDisplayForm) { // If form was initially hidden, re-hide it
                form.classList.add('hidden');
            }
        });
    });
</script>
@endsection
