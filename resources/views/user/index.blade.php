@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Judul Halaman -->
    <h2 class="mb-4 text-center">Daftar Semua User</h2>

    <!-- Form Pencarian -->
    <form action="{{ route('users.all') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari nama atau email..." value="{{ request()->get('search') }}">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </div>
    </form>

    <!-- Jika ada pengguna -->
    @if($users->count())
        <div class="list-group">
            @foreach($users as $user)
            <a href="{{ route('users.show', $user->id) }}" class="list-group-item list-group-item-action d-flex align-items-center p-3 mb-2 border rounded shadow-sm">
                
                <!-- Foto Profil -->
                <div class="d-flex align-items-center me-3">
                    @if($user->profile_photo)
                        <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Foto Profil" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}" alt="Foto Default" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    @endif
                </div>

                <!-- Nama dan Email -->
                <div class="d-flex flex-column me-auto">
                    <strong>{{ $user->name }}</strong>
                    <small class="text-muted">{{ $user->email }}</small>
                </div>




            </a>
                          <!-- Tombol Edit dan Delete -->
            <div class="ms-auto d-flex align-items-center mb-1">
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-2">Edit</a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Delete</button>
                </form>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            Belum ada user yang terdaftar.
        </div>
    @endif

</div>
@endsection
