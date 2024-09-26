<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class ProfileUserController extends Controller
{

    public function edit(Request $request): View
    {
        $user = $request->user();
        $profile = $user->profile;

        return view('user.profile', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();
    $user->fill($request->validated());

    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }

    $user->save();

    $profileData = [
        'addres' => $request->input('addres'),
        'phone' => $request->input('phone'),
    ];

    // Cek jika ada file yang diunggah
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        // Simpan file ke penyimpanan
        $image->storeAs('public/profile_photos', $imageName);

        // Hapus foto lama jika ada
        $profile = $user->profile;
        if ($profile && $profile->photo) {
            $oldPhotoPath = 'public/profile_photos/' . $profile->photo;

            if (Storage::exists($oldPhotoPath)) {
                Storage::delete($oldPhotoPath);
            }
        }

        $profileData['photo'] = $imageName;
    }

    // Update atau buat profil
    $user->profile()->updateOrCreate(
        ['user_id' => $user->id],
        $profileData
    );

    return Redirect()->route('dashboard')->with(['success' => 'Profile telah di update']);
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


    public function Password(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Update the user's password
        $user = $request->user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('dashboard')->with(['success' => 'password telah di update']);
    }
}
