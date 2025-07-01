@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 to-blue-50 py-8 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Profil Mahasiswa</h1>
            {{-- <p class="text-gray-600">Kelola informasi profil dan foto Anda</p> --}}
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-400 p-4 mb-6 rounded-r-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-emerald-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-emerald-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6 rounded-r-lg" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-red-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-red-800 font-medium">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
            <!-- Profile Image Section -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            Foto Profil
                        </h3>

                        <!-- Current Image Display -->
                        <div class="relative mb-6">
                            <div class="mx-auto w-40 h-40 relative group">
                                @if($mahasiswa->gambar && Storage::disk('public')->exists($mahasiswa->gambar))
                                    <img src="{{ asset('storage/' . $mahasiswa->gambar) }}"
                                         alt="Profile Picture"
                                         class="w-full h-full rounded-full object-cover border-4 border-white shadow-lg ring-4 ring-blue-100 transition-all duration-300 group-hover:ring-blue-200"
                                         id="profile-image">
                                @else
                                    <div class="w-full h-full rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center shadow-lg ring-4 ring-blue-100 transition-all duration-300 group-hover:ring-blue-200"
                                         id="profile-placeholder">
                                        <span class="text-white text-3xl font-bold">
                                            {{ substr($mahasiswa->nama_lengkap ?? $user->name ?? 'N/A', 0, 2) }}
                                        </span>
                                    </div>
                                @endif

                                <!-- Overlay for hover effect -->
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Upload Form -->
                        <form action="{{ route('mahasiswa.profile.image.update') }}"
                              method="POST"
                              enctype="multipart/form-data"
                              id="image-upload-form"
                              class="space-y-4">
                            @csrf

                            <!-- Hidden File Input -->
                            <input type="file"
                                   id="gambar-input"
                                   name="gambar"
                                   accept="image/jpeg,image/png,image/gif,image/webp"
                                   class="hidden">

                            <!-- Custom Upload Button -->
                            <button type="button"
                                    onclick="document.getElementById('gambar-input').click()"
                                    class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <span>Pilih & Upload Foto</span>
                            </button>

                            @error('gambar')
                                <div class="text-sm text-red-600 bg-red-50 p-2 rounded-lg border border-red-200">
                                    {{ $message }}
                                </div>
                            @enderror
                        </form>

                        <!-- Upload Guidelines -->
                        <div class="mt-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-xs text-gray-600 mb-2 font-medium">Panduan Upload:</p>
                            <ul class="text-xs text-gray-500 space-y-1 text-left">
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-gray-400 rounded-full mr-2"></span>
                                    Format: JPG, PNG, GIF, WebP
                                </li>
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-gray-400 rounded-full mr-2"></span>
                                    Ukuran maksimal: 2MB
                                </li>
                                <li class="flex items-center">
                                    <span class="w-1 h-1 bg-gray-400 rounded-full mr-2"></span>
                                    Rasio 1:1 (persegi) direkomendasikan
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information Section -->
            <div class="xl:col-span-3">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="flex items-center mb-8">
                        <svg class="w-6 h-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <h3 class="text-2xl font-bold text-gray-800">Informasi Profil</h3>
                    </div>

                    <form class="space-y-8">
                        <!-- Basic Information -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Lengkap -->
                            <div class="lg:col-span-2">
                                <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <span class="flex items-center">
                                        Nama Lengkap
                                        <span class="text-red-500 ml-1">*</span>
                                        <svg class="w-4 h-4 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="text"
                                           id="nama_lengkap"
                                           name="nama_lengkap"
                                           value="{{ $mahasiswa->nama_lengkap ?? 'Tidak tersedia' }}"
                                           class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-gray-50 text-gray-700 font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('nama_lengkap') border-red-300 bg-red-50 @enderror"
                                           readonly>
                                    {{-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div> --}}
                                </div>
                                @error('nama_lengkap')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="lg:col-span-2">
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-3">
                                    <span class="flex items-center">
                                        Email Address
                                        <span class="text-red-500 ml-1">*</span>
                                        <svg class="w-4 h-4 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input type="email"
                                           id="email"
                                           name="email"
                                           value="{{ old('email', $user->email ?? 'Tidak tersedia') }}"
                                           class="w-full px-4 py-3 mb-12 border border-gray-200 rounded-xl bg-gray-50 text-gray-700 font-medium focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 @error('email') border-red-300 bg-red-50 @enderror"
                                           readonly>
                                    {{-- <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div> --}}
                                </div>
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                            <a href="{{ route('mahasiswa.profile.change-password') }}"
                               class="flex-1 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                <span>Ubah Password</span>
                            </a>
                        </div>

                        <!-- Information Notice -->
                        {{-- <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-semibold text-blue-800 mb-1">Informasi Penting</h4>
                                    <p class="text-sm text-blue-700">
                                        Data profil ini bersifat read-only dan tidak dapat diubah melalui sistem ini.
                                        Jika ada kesalahan data, silakan hubungi administrator untuk melakukan perubahan.
                                    </p>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('gambar-input');
    const profileImage = document.getElementById('profile-image');
    const profilePlaceholder = document.getElementById('profile-placeholder');
    const uploadForm = document.getElementById('image-upload-form');

    // Image preview functionality
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];

            if (file) {
                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    this.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    alert('Format file tidak didukung. Gunakan JPG, PNG, GIF, atau WebP.');
                    this.value = '';
                    return;
                }

                // Create preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imageContainer = profileImage ? profileImage.parentNode : profilePlaceholder.parentNode;

                    // Create new image element
                    const newImg = document.createElement('img');
                    newImg.src = e.target.result;
                    newImg.alt = 'Profile Picture Preview';
                    newImg.className = 'w-full h-full rounded-full object-cover border-4 border-white shadow-lg ring-4 ring-blue-100 transition-all duration-300 group-hover:ring-blue-200';
                    newImg.id = 'profile-image';

                    // Replace current image/placeholder
                    const currentElement = profileImage || profilePlaceholder;
                    imageContainer.replaceChild(newImg, currentElement);
                };
                reader.readAsDataURL(file);

                // Auto submit form after preview
                setTimeout(() => {
                    uploadForm.submit();
                }, 500);
            }
        });
    }

    // Enhanced drag and drop functionality
    const imageContainer = document.querySelector('.w-40.h-40.relative.group');
    if (imageContainer) {
        imageContainer.addEventListener('dragover', function(e) {
            e.preventDefault();
            this.classList.add('ring-blue-300', 'ring-offset-2');
        });

        imageContainer.addEventListener('dragleave', function(e) {
            e.preventDefault();
            this.classList.remove('ring-blue-300', 'ring-offset-2');
        });

        imageContainer.addEventListener('drop', function(e) {
            e.preventDefault();
            this.classList.remove('ring-blue-300', 'ring-offset-2');

            const files = e.dataTransfer.files;
            if (files.length > 0) {
                imageInput.files = files;
                imageInput.dispatchEvent(new Event('change', { bubbles: true }));
            }
        });
    }

    // Show loading state during form submission
    if (uploadForm) {
        uploadForm.addEventListener('submit', function() {
            const submitButton = this.querySelector('button[type="button"]');
            if (submitButton) {
                submitButton.innerHTML = `
                    <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Mengupload...
                `;
                submitButton.disabled = true;
            }
        });
    }
});
</script>
@endsection
