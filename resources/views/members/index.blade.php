
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Anggota - Perpustakaan</title>
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
        <h3>Data Anggota</h3>
        <a href="{{ route('members.create') }}" class="btn btn-primary">+ Tambah Anggota</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form action="{{ route('members.index') }}" method="GET">
                <div class="row g-2">
                    <div class="col-md-4">
                        <label class="form-label">Pencarian</label>
                        <input type="text" name="search" class="form-control"
                               placeholder="Kode, nama, email, atau telepon"
                               value="{{ $search }}">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Urutkan Berdasarkan</label>
                        <select name="sort" class="form-select">
                            <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Nama</option>
                            <option value="member_code" {{ $sort === 'member_code' ? 'selected' : '' }}>Kode Anggota</option>
                            <option value="joined_at" {{ $sort === 'joined_at' ? 'selected' : '' }}>Tanggal Bergabung</option>
                            <option value="created_at" {{ $sort === 'created_at' ? 'selected' : '' }}>Tanggal Dibuat</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Arah Urutan</label>
                        <select name="direction" class="form-select">
                            <option value="asc" {{ $direction === 'asc' ? 'selected' : '' }}>A-Z / Terlama</option>
                            <option value="desc" {{ $direction === 'desc' ? 'selected' : '' }}>Z-A / Terbaru</option>
                        </select>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('members.index') }}" class="btn btn-outline-secondary btn-sm">Reset Filter</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <p class="text-muted">
                Menampilkan {{ $members->count() }} dari {{ $members->total() }} anggota.
            </p>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>No</th>
                        <th>Kode Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tanggal Bergabung</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                        <tr>
                            <td>{{ $members->firstItem() + $loop->index }}</td>
                            <td>{{ $member->member_code }}</td>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->email ?? '-' }}</td>
                            <td>{{ $member->phone ?? '-' }}</td>
                            <td>{{ $member->joined_at ? $member->joined_at->format('d-m-Y') : '-' }}</td>
                            <td>
                                @if($member->status === 'active')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus anggota ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Data anggota tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $members->links() }}
        </div>
    </div>
</div>

</body>
</html>
