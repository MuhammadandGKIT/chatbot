@extends('layouts.users')

@section('content')
<div class="container">
    <h2 class="mb-5 text-center" style="font-weight: bold; color: #343a40;">Profil Pengguna</h2>

    <div class="row align-items-start mb-5 shadow-sm p-4 rounded" style="background-color: #f8f9fa;">
        <div class="col-md-3 text-center mb-4 mb-md-0">
            @if($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" class="img-thumbnail rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Profil">
            @else
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" class="img-thumbnail rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;" alt="Foto Default">
            @endif
        </div>

        <div class="col-md-5 mb-4 mb-md-0">
            <h3 style="font-weight: 600;">{{ $user->name }}</h3>
            <p class="mb-2" style="font-size: 16px;"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-3" style="font-size: 16px;"><strong>Role:</strong> <span class="badge bg-secondary">{{ ucfirst($user->role) }}</span></p>
        </div>

        <div class="col-md-4">
            <form action="{{ route('user.photos.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="photos" class="form-label fw-bold">Pilih Beberapa Foto:</label>
                    <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
                </div>
                <button type="submit" class="btn btn-primary w-100">Upload</button>
            </form>
        </div>
    </div>
    @if(auth()->id() === $user->id || auth()->user()->role === 'admin')

    <!-- Tombol trigger modal -->
    <div class="text-end mb-4">
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editProfileModal">
            Edit Profil
        </button>
    </div>
    
    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <form action="{{ route('user.profile.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="editProfileModalLabel">Edit Profil Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
    
                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
    
                <div class="mb-3">
                    <label for="profile_photo" class="form-label">Ubah Foto Profil</label>
                    <input type="file" name="profile_photo" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </form>
      </div>
    </div>
    @endif
    

    <h4 class="mb-4 text-center" style="font-weight: bold;">Foto Unggahan {{ $user->name }}</h4>

    @if($user->photos->count())
        <div class="row">
            @foreach($user->photos as $photo)
                <div class="col-md-3 col-sm-6 mb-4">
                    <div class="card shadow-sm border-0" style="border-radius: 12px; overflow: hidden;">
                        <img src="{{ asset('uploads/user_photos/' . $photo->filename) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Foto">
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">Belum ada foto yang diunggah.</div>
    @endif
</div>
@endsection
