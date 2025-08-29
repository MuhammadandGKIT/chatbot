@extends('layouts.users')

@section('content')
<div class="container">
    <h2 class="mb-4 text-center">Galeri Publik</h2>

    @if($photos->count())
        <div class="row">
            @foreach($photos as $photo)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-lg border-light">
                        <img src="{{ asset('uploads/user_photos/' . $photo->filename) }}" class="card-img-top img-fluid rounded" alt="Foto Galeri" style="object-fit: cover; height: 200px;">

                        <div class="card-body text-center">
                            <small class="text-muted">Diunggah oleh:</small><br>
                            <strong>{{ $photo->user->name }}</strong>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info text-center">
            Belum ada foto yang tersedia di galeri publik.
        </div>
    @endif
</div>
@endsection
