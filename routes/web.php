<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;


use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserPhotoController;
Route::get('admin/users/create', [AuthController::class, 'create'])->name('users.create');
Route::post('admin/users', [AuthController::class, 'store'])->name('users.store');

Route::middleware(['auth'])->group(function() {
    // Menampilkan form edit user
    Route::get('users/{user}/edit', [AuthController::class, 'edit'])->name('users.edit');

    // Proses update user
    Route::put('users/{user}', [AuthController::class, 'update'])->name('users.update');

    // Hapus user
    Route::delete('users/{user}', [AuthController::class, 'destroy'])->name('users.destroy');
});

Route::get('user/profile/edit', function () {
    return view('profile');
})->middleware('auth')->name('profile.edit');


Route::get('/users', [UserPhotoController::class, 'allUsers'])->name('users.all');
Route::get('/users/{id}', [UserPhotoController::class, 'show'])->name('users.show');
Route::put('/profile/{id}', [ProfileController::class, 'perbarui'])->name('user.profile.update');

// Route::get('/user/photos', function () {
//     return view('user.photos');
// })->middleware('auth')->name('user.photos');



Route::get('/galeri-publik', [UserPhotoController::class, 'publicGallery'])->name('galeri.publik');

Route::post('/user/photos/upload', [UserPhotoController::class, 'upload'])->name('user.photos.upload');

Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');



Route::get('register/admin', [AuthController::class, 'showRegisterForm'])->name('register');
Route::get('register', [AuthController::class, 'registrasi_user'])->name('register_user');
Route::post('register', [AuthController::class, 'register']);

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('dashboard', [AuthController::class, 'dashboard'])->middleware('auth')->name('dashboard');

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


Route::get('/', function () {
    return view('welcome');
});






