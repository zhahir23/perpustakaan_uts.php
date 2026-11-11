
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit User - Perpustakaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Sistem Perpustakaan</a>
    </div>
</nav>

<div class="container">
    <div class="card shadow-sm mx-auto" style="max-width: 650px;">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Data User</h5>
        </div>

        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Password Baru</label>
                    <input type="password" name="password" class="form-control"
                           minlength="8" autocomplete="new-password">
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengubah password.
                    </small>
                </div>

                @if($user->id === auth()->id())
                    <div class="mb-3">
                        <label class="form-label">Hak Akses (Role)</label>
                        <input type="text" class="form-control"
                               value="{{ ucfirst($user->role) }}" disabled>
                        <small class="text-muted">
                            Role akun sendiri tidak dapat diubah.
                        </small>
                    </div>
                @else
                    <div class="mb-3">
                        <label class="form-label">Hak Akses (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="admin"
                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="petugas"
                                {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>
                                Petugas
                            </option>
                        </select>
                    </div>
                @endif

                <div class="d-flex justify-content-between">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
