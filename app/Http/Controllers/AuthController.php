<?php

namespace App\Http\Controllers;

use App\Models\User;

use App\Models\UserPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    /**
     * Menampilkan halaman register.
     *
     * @return \Illuminate\View\View
     */



     
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function registrasi_user()
    {
        return view('auth.non_admin.register');
    }

    /**
     * Proses register pengguna baru.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user', // Pastikan role valid
        ]);
    
        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Menyimpan pengguna baru
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Menyimpan role pengguna
            ]);
    
            // Mengarahkan ke halaman login dengan pesan sukses
            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            // Mengarahkan ke halaman registrasi dengan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pengguna, silakan coba lagi.');
        }
    }
    



    

    /**
     * Menampilkan halaman login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Proses autentikasi
        if (Auth::attempt($credentials)) {
            // Jika login berhasil
            $request->session()->regenerate();
    
            // Mengirim pesan sukses ke session
            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }
    
        // Jika login gagal, mengirim pesan error ke session
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->with('error', 'Login gagal, silakan coba lagi.');
    }
    

    /**
     * Halaman dashboard setelah login.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = Auth::user(); // Ambil user yang sedang login
        $photos = UserPhoto::with('user')->latest()->get();
        if ($user->role === 'admin') {
            // Admin bisa lihat semua user
            $users = User::all();
        } else {
            // Non-admin hanya bisa lihat dirinya sendiri
            $users = collect([$user]); // Buat jadi collection agar seragam di view
        }
    
        return view('dashboard', compact('users','photos'));
    }


    public function create()
    {
        return view('auth.non_admin.add_users'); // Pastikan kamu punya view 'create' untuk form
    }

    public function store(Request $request)
    {
        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:admin,user', // Pastikan role valid
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Menyimpan pengguna baru
        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, // Menyimpan role pengguna
            ]);

            // Mengarahkan ke halaman daftar user dengan pesan sukses
            return redirect()->route('dashboard')->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Mengarahkan ke halaman form tambah user dengan pesan error jika terjadi kesalahan
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data pengguna, silakan coba lagi.');
        }
    }
    
    /**
     * Proses logout pengguna.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }



    public function edit(User $user)
    {
        // Cek apakah user yang sedang login adalah admin
        if (Auth::user()->role !== 'admin' && Auth::user()->id !== $user->id) {
            return redirect()->route('dashboard')->with('error', 'Akses ditolak!');
        }

        return view('auth.edit', compact('user')); // Tampilkan form edit user
    }

    /**
     * Proses pembaruan data user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        // Validasi input untuk pembaruan user
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|in:admin,user', // Pastikan role valid
        ]);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role, // Pastikan role dapat diubah hanya oleh admin
        ]);

        return redirect()->route('dashboard')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Cek jika user yang dihapus adalah user yang sedang login
        if (Auth::user()->id === $user->id) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        // Hapus user
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User berhasil dihapus!');
    }
}
