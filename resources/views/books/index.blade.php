
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary">
    <div class="container">
        <a href="{{ route('dashboard') }}" class="navbar-brand">Sistem Perpustakaan</a>
        <a href="{{ route('dashboard') }}" class="btn btn-light btn-sm">Dashboard</a>
    </div>
</nav>

<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Data Buku</h3>
        <a href="{{ route('books.create') }}" class="btn btn-primary">+ Tambah Buku</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('books.index') }}" method="GET">
                <div class="row g-2">

                    <div class="col-md-4">
                        <label class="form-label">Cari Buku</label>
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Judul, penulis, penerbit, atau ISBN..."
                            value="{{ $search }}"
                        >
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $categoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Urutkan</label>
                        <select name="sort" class="form-select">
                            <option value="title" {{ $sort == 'title' ? 'selected' : '' }}>Judul</option>
                            <option value="author" {{ $sort == 'author' ? 'selected' : '' }}>Penulis</option>
                            <option value="publication_year" {{ $sort == 'publication_year' ? 'selected' : '' }}>Tahun</option>
                            <option value="stock" {{ $sort == 'stock' ? 'selected' : '' }}>Stok</option>
                            <option value="created_at" {{ $sort == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Urutan</label>
                        <select name="direction" class="form-select">
                            <option value="asc" {{ $direction == 'asc' ? 'selected' : '' }}>Naik (A-Z)</option>
                            <option value="desc" {{ $direction == 'desc' ? 'selected' : '' }}>Turun (Z-A)</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('books.index') }}" class="btn btn-outline-secondary btn-sm">
                        Reset Filter
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="mb-3 text-muted">
                Menampilkan {{ $books->count() }} dari {{ $books->total() }} data buku.
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>No.</th>
                            <th>Judul Buku</th>
                            <th>Kategori</th>
                            <th>Penulis</th>
                            <th>Penerbit</th>
                            <th>Tahun</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($books as $book)
                            <tr>
                                <td>{{ $books->firstItem() + $loop->index }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->category->name ?? '-' }}</td>
                                <td>{{ $book->author }}</td>
                                <td>{{ $book->publisher ?? '-' }}</td>
                                <td>{{ $book->publication_year ?? '-' }}</td>
                                <td>{{ $book->stock }}</td>
                                <td>
                                    <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    Tidak ada data buku yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $books->links() }}
            </div>

        </div>
    </div>
</div>

</body>
</html>
