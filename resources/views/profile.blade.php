@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Upload Foto Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mb-5">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="photo" class="form-label">Foto Profil</label>
            <input type="file" name="photo" class="form-control" accept="image/*" required>
        </div>

        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr>

    <h4 class="mb-3">Foto Saat Ini</h4>
    @if(auth()->user()->profile_photo)
        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" class="img-thumbnail" style="max-width: 200px;">
    @else
        <p class="text-muted">Belum ada foto.</p>
    @endif
</div>
@endsection
