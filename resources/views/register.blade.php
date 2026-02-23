<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tridjaya Merdeka Motor - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f8f9fa;
        }
        .register-card {
            width: 350px;
            padding: 20px;
            border-radius: 10px;
            background: white;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-close-small {
            font-size: 0.5rem !important; 
            padding: 0.6rem !important;
        }
        .alert-small {
            font-size: 0.85rem;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>

    <div class="register-card" style="width: 400px;">
        <h3 class="text-center mb-4">Daftar Admin Baru</h3>

        <!-- @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show alert-small" role="alert">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-small" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif -->
        <div class="mt-2">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3 mb-3" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <div class="flex-grow-1" style="font-size: 0.85rem;">{{ session('error') }}</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.5rem; position: static; margin-left: 10px; padding: 0.5rem;"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show py-2 px-3 mb-3" role="alert">
                    <ul class="mb-0" style="font-size: 0.85rem; padding-left: 15px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.5rem; position: static; margin-left: 10px; padding: 0.5rem;"></button>
                </div>
            @endif
        </div>

        <form action="{{ route('register.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nama Lengkap</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Ulangi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="kode_admin" class="form-label text-primary"><strong>Kode Admin Khusus</strong></label>
                <input type="text" name="kode_admin" id="kode_admin" class="form-control border-primary" placeholder="Masukkan kode rahasia" required>
                <small class="text-muted">Hanya pihak bengkel yang memiliki kode ini.</small>
            </div>

            <button type="submit" class="btn btn-success w-100">Daftar Akun</button>
            <p class="text-center mt-3 mb-0">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
