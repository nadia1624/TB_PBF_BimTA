<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
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
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
}
