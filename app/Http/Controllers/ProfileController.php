<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = Auth::user();
        $request->$user()->fill($request->validated());

        if ($request->$user()->isDirty('email')) {
            $request->$user()->email_verified_at = null;
        }

        $request->$user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display dosen profile
     */
    public function dosenProfile(): View
    {
        $user = Auth::user();
        $dosen = $user->dosen; // Assuming User model has dosen relationship

        return view('dosen.profile', compact('dosen', 'user'));
    }

    /**
     * Update dosen profile image
     */

    public function updateDosenImage(Request $request): RedirectResponse
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $dosen = $user->dosen;

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($dosen->gambar && Storage::disk('public')->exists($dosen->gambar)) {
                Storage::disk('public')->delete($dosen->gambar);
            }

            // Store new image
            $imagePath = $request->file('gambar')->store('dosen/images', 'public');

            // Update dosen record
            $dosen->update([
                'gambar' => $imagePath
            ]);

            return redirect()->route('dosen.profile')
                ->with('success', 'Foto profil berhasil diperbarui!');
        }

        return redirect()->route('dosen.profile')
            ->with('error', 'Gagal memperbarui foto profil!');
    }

    /**
     * Display the student's profile.
     */
    public function showProfile(Request $request): View
    {
        $user = Auth::user();

        // Use mahasiswa if it exists, otherwise fallback to user
        $mahasiswa = $user->mahasiswa ?? $user;

        return view('profile.edit', compact('mahasiswa', 'user'));
    }

    /**
     * Update student's profile image.
     */
    public function updateProfileImage(Request $request): RedirectResponse
    {
        // Validasi file yang diupload
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Ambil user yang sedang login dan relasi mahasiswa-nya
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        if (!$mahasiswa) {
            return back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }

        // Proses jika file benar-benar dikirim
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');

            // Buat nama file unik
            $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

            // Simpan file ke storage/app/public/mahasiswa/images
            $path = $file->storeAs('mahasiswa/images', $filename, 'public');

            // Hapus gambar lama jika ada
            if ($mahasiswa->gambar && Storage::disk('public')->exists($mahasiswa->gambar)) {
                Storage::disk('public')->delete($mahasiswa->gambar);
            }

            // Simpan path gambar ke database
            $mahasiswa->update([
                'gambar' => $path,
            ]);

            return redirect()->route('mahasiswa.profile.show')->with('success', 'Foto profil berhasil diperbarui!');
        }

        return back()->with('error', 'Gagal memperbarui foto profil.');
    }

    /**
     * Display the form to change the user's password.
     */
    public function showChangePasswordForm(): View
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa ?? $user;

        return view('profile.change-password', compact('mahasiswa', 'user'));
    }

    /**
     * Update user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        // Validasi inputD
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required', 'string', 'min:8'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'new_password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('mahasiswa.profile.change-password')
            ->with('success', 'Password berhasil diubah!');
    }

    public function showChangePasswordDosen(): View
    {
        $user = Auth::user();
        $dosen = $user->dosen ?? $user;

        return view('dosen.change-password', compact('dosen', 'user'));
    }

    public function updatePasswordDosen(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            'new_password_confirmation' => ['required', 'string', 'min:8'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'new_password.required' => 'Password baru wajib diisi.',
            'new_password.min' => 'Password baru minimal 8 karakter.',
            'new_password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'new_password_confirmation.min' => 'Konfirmasi password minimal 8 karakter.',
        ]);

        $user = Auth::user();

        // Update password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Perbaikan: redirect ke dosen, bukan mahasiswa
        return redirect()->route('dosen.change-password')
            ->with('success', 'Password berhasil diubah!');
    }

}
