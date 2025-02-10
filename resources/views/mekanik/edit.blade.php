@extends('layouts.app')

@section('content')
    <h2>Edit Data Mekanik</h2>
    <br>

    <form action="{{ route('mekanik.update', $mekanik->id_mekanik) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div class="mb-3">
            <label for="nama_mekanik" class="form-label">Nama:</label>
            <input type="text" class="form-control" name="nama_mekanik" id="nama_mekanik" value="{{ old('nama_mekanik', $mekanik->nama_mekanik) }}" maxlength="30" autocomplete="off" required>
            <div class="form-text">Maksimal 30 karakter</div>
        </div>

        <!-- NPWP -->
        <div class="mb-3">
            <label for="npwp" class="form-label">NPWP:</label>
            <input type="text" class="form-control" name="npwp" id="npwp" value="{{ old('npwp', $mekanik->npwp) }}" maxlength="16" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan">
            <div class="form-text">Maksimal 16 digit (hanya angka)</div>
        </div>

        <!-- No Telepon -->
        <div class="mb-3">
            <label for="no_telepon" class="form-label">No Telepon:</label>
            <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $mekanik->no_telepon) }}" maxlength="15" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan" required>
            <div class="form-text">Maksimal 15 digit (hanya angka)</div>
        </div>

        <!-- Tombol Update dan Batal -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('mekanik.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
