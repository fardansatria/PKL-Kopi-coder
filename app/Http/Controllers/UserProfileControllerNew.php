<?

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Storage;

class UserProfileControllerNew extends Controller
{
    public function edit()
    {
        $userProfile = UserProfile::where('user_id', Auth::id())->first();
        return view('user.profile', compact('userProfile'));
    }

    public function update(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $request->validate([
            'addres' => 'nullable|string|max:255',
            'type' => 'nullable|string|in:laki_laki,perempuan',
            'phone' => 'nullable|string|max:15',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $userProfile = UserProfile::where('user_id', Auth::id())->first();

        // Jika profil belum ada, buat baru
        if (!$userProfile) {
            $userProfile = new UserProfile();
            $userProfile->user_id = Auth::id();
        }

        $userProfile->address = $request->input('addres');
        $userProfile->type = $request->input('type');
        $userProfile->phone = $request->input('phone');

        if ($request->hasFile('photo')) {
            if ($userProfile->photo && Storage::exists('public/photos/' . $userProfile->photo)) {
                Storage::delete('public/photos/' . $userProfile->photo);
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/photos', $filename);

            $userProfile->photo = $filename;
        }

        $userProfile->save();

        return redirect()->route('user.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }
}
