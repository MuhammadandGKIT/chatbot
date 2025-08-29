@extends('layouts.users')

@section('content')

    <div class="container my-5">
        <h1 class="text-start mb-4">Welcome to Your Dashboard</h1>

        {{-- <!-- Profil Pengguna -->
        <div class="row mb-4 justify-content-center">
            <div class="col-12 col-md-3 text-center">
                @if(auth()->user()->profile_photo)
                    <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" class="rounded-circle mb-2" width="120" height="120">
                @else
                    <img src="{{ asset('images/default.png') }}" alt="Default Foto" class="rounded-circle mb-2" width="120" height="120">
                @endif
                
                <h5>{{ auth()->user()->name }}</h5>
                <p class="text-muted">{{ auth()->user()->email }}</p>
            </div>
        </div> --}}

        <!-- Admin Actions atau User Profile -->
        @if(auth()->user()->role == 'admin')
            <div class="alert alert-info text-center mb-4">
                <h4>Admin Actions</h4>
                <a href="{{ route('users.create') }}" class="btn btn-success">Add New User</a>
            </div>

            <!-- Daftar Pengguna -->
            <div class="list-group">
                @foreach($users as $user)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $user->name }} ({{ $user->email }})</span>

                        <div class="btn-group gap-2" role="group">
                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm ">Edit</a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Tampilan Pengguna Biasa -->
            <div class="alert alert-warning text-center mb-4">
                <h4>Your Account</h4>
                <p>you can view and update your account information.</p>
            </div>
        @endif

        <!-- Foto yang Diupload oleh Pengguna -->
        <div class="mb-4">
            <h4 class="text-center">Uploaded Photos</h4>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($photos as $photo)
                    <div class="col">
                        <div class="card shadow-sm">
                            <img src="{{ asset('uploads/user_photos/' . $photo->filename) }}" 
                                 class="card-img-top" 
                                 alt="Uploaded Photo" 
                                 style="object-fit: cover; height: 200px; width: 100%; border-radius: 10px;">
                            <div class="card-body text-center">
                                <p class="card-text">by: {{ $photo->user->name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        

        {{-- <!-- Form Logout -->
        <form action="{{ url('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger w-100">Logout</button>
        </form> --}}
    </div>

    <!-- Link untuk Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

@endsection
