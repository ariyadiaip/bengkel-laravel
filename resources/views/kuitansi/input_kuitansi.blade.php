<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tridjaya Merdeka Motor - Publik</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100 bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body text-center">
                    <h3 class="mb-4">Cek Kuitansi</h3>
                    <form action="{{ route('cek-kuitansi.proses') }}" method="GET">
                        @csrf
                        <div class="mb-3">
                            <input type="text" class="form-control" name="no_kuitansi" placeholder="Masukkan No. Kuitansi" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Cek Kuitansi</button>
                    </form>

                    @if(session('error'))
                        <div class="alert alert-danger mt-3">
                            {{ session('error') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
