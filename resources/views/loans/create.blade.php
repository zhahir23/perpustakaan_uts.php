 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Peminjaman - Perpustakaan</title>
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
    <div class="mb-4">
        <h2>Tambah Peminjaman</h2>
        <p class="text-muted">Lengkapi data anggota dan buku yang akan dipinjam.</p>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('loans.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Anggota</label>
                    <select name="member_id" class="form-select" required>
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                                {{ $member->member_code }} - {{ $member->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Buku</label>
                    <select name="book_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($books as $book)
                            <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->title }} (Stok: {{ $book->stock }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Jumlah Buku</label>
                    <input type="number" name="quantity" class="form-control"
                        min="1" value="{{ old('quantity', 1) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="date" name="loan_date" class="form-control"
                            value="{{ old('loan_date', date('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Batas Pengembalian</label>
                        <input type="date" name="due_date" class="form-control"
                            value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Catatan (Opsional)</label>
                    <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
                </div>

                <hr>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Apakah data peminjaman sudah benar dan ingin dikonfirmasi?')">
                        Konfirmasi Peminjaman
                    </button>

                    <a href="{{ route('loans.index') }}" class="btn btn-secondary">
                        Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>