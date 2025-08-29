<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserPhoto;
use Illuminate\Support\Facades\Auth;

class UserPhotoController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $filename = time() . '_' . $photo->getClientOriginalName();
                $photo->move(public_path('uploads/user_photos'), $filename);

                // Simpan ke database
                UserPhoto::create([
                    'user_id' => $user->id,
                    'filename' => $filename,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Foto berhasil diunggah!');
    }

    public function publicGallery()
{
    $photos = UserPhoto::with('user')->latest()->get(); // ambil semua foto beserta user-nya
    return view('galeri.publik', compact('photos'));
}




//user
public function allUsers(Request $request)
{
    $query = User::query(); // Query builder untuk User

    // Cek apakah ada input pencarian
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
    }

    $users = $query->get(); // Ambil data user setelah difilter

    return view('user.index', compact('users'));
}


public function show($id)
{
    $user = User::with('photos')->findOrFail($id);
    return view('user.show', compact('user'));
}


}
