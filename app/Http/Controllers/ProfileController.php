<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{


   

    public function update(Request $request)
    {
        $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $user = Auth::user();
    
        if ($request->hasFile('photo')) {
            // Hapus foto lama kalau ada
            if ($user->profile_photo) {
                Storage::delete('public/' . $user->profile_photo);
            }
    
            // Simpan foto baru
            $path = $request->file('photo')->store('photos', 'public');
            $user->profile_photo = $path;
        }
     /** @var \App\Models\User $user */
        $user->save();
    
        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }



    public function perbarui(Request $request, $id)
{
    $user = User::findOrFail($id);

    if (Auth::id() !== $user->id) {
        abort(403);
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user->name = $request->name;
    $user->email = $request->email;

    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->profile_photo = $path;
    }

    $user->save();

    return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
}

    
}