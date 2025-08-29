@extends('layouts.app') {{-- atau layout yang kamu pakai --}}

@section('content')
<div class="container">
    <h2 class="mb-4">Upload Foto Galeri</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Upload Foto --}}
    <form action="{{ route('user.photos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="photos" class="form-label">Pilih Beberapa Foto:</label>
            <input type="file" name="photos[]" class="form-control" multiple accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <hr class="my-4">

    <h4>Galeri Foto Anda:</h4>

    @if(auth()->user()->photos->count())
        <div class="row">
            @foreach(auth()->user()->photos as $photo)
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <img src="{{ asset('uploads/user_photos/' . $photo->filename) }}" class="card-img-top" alt="Foto">
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>Belum ada foto yang diunggah.</p>
    @endif
</div>
@endsection
