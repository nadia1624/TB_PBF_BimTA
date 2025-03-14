<x-guest-layout>
    <div class="flex flex-col md:flex-row h-screen">
        <!-- Left Section with Login Form -->
        <div class="w-full md:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md">
                <!-- Welcome Text -->
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">WELCOME!</h1>
                </div>

                <!-- Login Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-8">
                    <h2 class="text-xl font-semibold text-center mb-6">SIGN IN</h2>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Username/Email Input -->
                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" id="email" name="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#638B35] focus:border-[#638B35] block w-full p-2.5"
                                placeholder="Email Pengguna" required autofocus autocomplete="username" :value="old('email')">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" id="password" name="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-[#638B35] focus:border-[#638B35] block w-full p-2.5"
                                placeholder="Password Pengguna" required autocomplete="current-password">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me (Hidden but kept for functionality) -->
                        <div class="hidden">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[#638B35] shadow-sm focus:ring-green-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                            </label>
                        </div>

                        <!-- Sign In Button -->
                        <button type="submit" class="w-full bg-[#638B35] hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 text-white font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            SIGN IN
                        </button>

                        <!-- Forgot Password Link (Hidden but kept for functionality) -->
                        <div class="hidden">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Section with Background Image and Logo -->
        <div class="hidden md:block md:w-1/2 bg-[#638B35] relative">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/path/to/your/campus-image.jpg'); opacity: 0.4;"></div>

            <!-- Logo Centered -->
            <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-6xl font-bold text-[#638B35]">
                        <div class="flex flex-col items-center">
                            <image src="/uploads/logo.png" alt="Your Logo" />
                            <img src="/uploads/namelogo.png" alt="BimTa Name" />
                        </div>
                    </div>
            </div>

            <!-- Subtle University Name at Bottom -->
            <div class="absolute bottom-4 w-full text-center text-white text-xs font-light">
                UNIVERSITAS ANDALAS
            </div>
        </div>
    </div>
</x-guest-layout>
