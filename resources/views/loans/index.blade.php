 
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Peminjaman - Perpustakaan</title>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Data Peminjaman</h2>
            <p class="text-muted mb-0">Kelola peminjaman dan pengembalian buku.</p>
        </div>
        <a href="{{ route('loans.create') }}" class="btn btn-primary">
            + Tambah Peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Petugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($loans as $loan)
                            <tr>
                                <td>{{ $loans->firstItem() + $loop->index }}</td>
                                <td>{{ $loan->member->name }}</td>
                                <td>
                                    @foreach ($loan->loanDetails as $detail)
                                        {{ $detail->book->title }}<br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($loan->loanDetails as $detail)
                                        {{ $detail->quantity }}<br>
                                    @endforeach
                                </td>
                                <td>{{ $loan->loan_date->format('d-m-Y') }}</td>
                                <td>{{ $loan->due_date->format('d-m-Y') }}</td>
                                <td>
                                    {{ $loan->return_date ? $loan->return_date->format('d-m-Y') : '-' }}
                                </td>
                                <td>
                                    @if ($loan->status === 'returned')
                                        <span class="badge bg-success">Dikembalikan</span>
                                    @elseif ($loan->status === 'late')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Dipinjam</span>
                                    @endif
                                </td>
                                <td>{{ $loan->user->name }}</td>
                                <td>
                                    @if ($loan->status !== 'returned')
                                        <form action="{{ route('loans.update', $loan->id) }}" method="POST"
                                            onsubmit="return confirm('Catat buku ini sudah dikembalikan?')">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">
                                                Kembalikan
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $loans->links() }}
            </div>
        </div>
    </div>
</div>

</body>
</html>