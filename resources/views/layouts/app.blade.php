<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Manajemen Produk')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('products.index') }}">Manajemen Produk</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.photos') }}">Upload foto</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.all') }}">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('galeri.publik') }}">Galeri publik</a>
                    </li>
        
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
     
        @yield('content')
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-4">
        &copy; {{ date('Y') }} Manajemen Produk - Laravel
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
