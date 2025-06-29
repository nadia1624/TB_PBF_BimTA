@extends('layouts.app')

@section('content')
<div class="w-full bg-gray-100 py-8 px-4">
    <div class="max-w-6xl mx-auto space-y-8">

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Image Section -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Foto Profil</h3>

                    <!-- Current Image Display -->
                    <div class="flex flex-col items-center">
                        <div class="relative mb-4">
                            @if($user->gambar && Storage::disk('public')->exists($user->gambar))
                                <img src="{{ Storage::url($user->gambar) }}"
                                     alt="Profile Picture"
                                     class="w-32 h-32 rounded-full object-cover border-4 border-blue-200 shadow-lg">
                            @else
                                <div class="w-32 h-32 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center shadow-lg">
                                    <span class="text-white text-2xl font-bold">
                                        {{ substr($mahasiswa->nama_lengkap ?? $user->name ?? 'N/A', 0, 2) }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Upload Form -->
                        <form action="{{ route('mahasiswa.profile.image.update') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              class="w-full">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Ubah Foto Profil
                                </label>

                                <!-- Hidden File Input -->
                                <input type="file"
                                       id="gambar-input"
                                       name="gambar"
                                       accept="image/*"
                                       class="hidden"
                                       onchange="this.form.submit()">

                                <!-- Custom Upload Button -->
                                <button type="button"
                                        onclick="document.getElementById('gambar-input').click()"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Pilih & Upload Foto
                                </button>

                                @error('gambar')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror

                                <p class="text-xs text-gray-500 mt-2 text-center">
                                    Format: JPG, PNG, GIF • Maksimal: 2MB
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Informasi Profil</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Lengkap -->
                        <div class="md:col-span-2">
                            <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   id="nama_lengkap"
                                   name="nama_lengkap"
                                   value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap ?? $user->name ?? 'Tidak tersedia') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('nama_lengkap') border-red-500 @enderror"
                                   readonly>
                            @error('nama_lengkap')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-500 @enderror"
                                   readonly>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview image before upload
    const imageInput = document.querySelector('input[name="gambar"]');
    const currentImage = document.querySelector('img[alt="Profile Picture"], .w-32.h-32.rounded-full');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (currentImage.tagName === 'IMG') {
                        currentImage.src = e.target.result;
                    } else {
                        // Replace div with img
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.alt = 'Profile Picture';
                        img.className = 'w-32 h-32 rounded-full object-cover border-4 border-blue-200 shadow-lg';
                        currentImage.parentNode.replaceChild(img, currentImage);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endsection
