@extends('layouts.app')

@section('content')
    <h2>Tambah Data Mekanik</h2>
    <br>

    <form action="{{ route('mekanik.store') }}" method="POST">
        @csrf
        <!-- Nama -->
        <div class="mb-3">
            <label for="nama_mekanik" class="form-label">Nama:</label>
            <input type="text" class="form-control" name="nama_mekanik" id="nama_mekanik" maxlength="30" autocomplete="off" required>
            <div class="form-text">Maksimal 30 karakter</div>
        </div>

        <!-- NPWP -->
        <div class="mb-3">
            <label for="npwp" class="form-label">NPWP:</label>
            <input type="text" class="form-control" name="npwp" id="npwp" maxlength="16" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan">
            <div class="form-text">Maksimal 16 digit (hanya angka)</div>
        </div>

        <!-- No Telepon -->
        <div class="mb-3">
            <label for="no_telepon" class="form-label">No Telepon:</label>
            <input type="text" class="form-control" name="no_telepon" id="no_telepon" maxlength="15" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan" required>
            <div class="form-text">Maksimal 15 digit (hanya angka)</div>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('mekanik.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
