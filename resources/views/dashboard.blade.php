
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <span class="navbar-brand">Sistem Perpustakaan</span>

        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-light btn-sm">Logout</button>
        </form>
    </div>
</nav>

<div class="container py-4">
    <h3>Dashboard</h3>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
    <p>Role: {{ ucfirst(auth()->user()->role) }}</p>

    <div class="row g-3 mt-2">

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Data Buku</h5>
                    <p>Kelola koleksi buku perpustakaan.</p>
                    <a href="{{ route('books.index') }}" class="btn btn-primary btn-sm">
                        Kelola Buku
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Data Kategori</h5>
                    <p>Kelola kategori buku perpustakaan.</p>
                    <a href="{{ route('categories.index') }}" class="btn btn-primary btn-sm">
                        Kelola Kategori
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Data Anggota</h5>
                    <p>Kelola data anggota perpustakaan.</p>
                    <a href="{{ route('members.index') }}" class="btn btn-primary btn-sm">
                        Kelola Anggota
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Peminjaman</h5>
                    <p>Kelola transaksi peminjaman dan pengembalian buku.</p>
                    <a href="{{ route('loans.index') }}" class="btn btn-primary btn-sm">
                        Kelola Peminjaman
                    </a>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5>Manajemen User</h5>
                    <p>Kelola akun Admin dan Petugas.</p>
                    <a href="{{ route('users.index') }}" class="btn btn-primary btn-sm">
                        Kelola User
                    </a>
                </div>
            </div>
        </div>
        @endif

    </div>
</div>

</body>
</html>
