@extends('layouts.app')

@section('content')
    <h2>Tambah Data Suku Cadang</h2>
    <br>

    <form action="{{ route('suku-cadang.store') }}" method="POST">
        @csrf
        <!-- Nama Suku Cadang -->
        <div class="mb-3">
            <label for="nama_suku_cadang" class="form-label">Nama Suku Cadang:</label>
            <input type="text" class="form-control" name="nama_suku_cadang" id="nama_suku_cadang" maxlength="30" autocomplete="off" required oninput="this.value = this.value.toUpperCase();">
            <div class="form-text">Maksimal 30 karakter</div>
        </div>

        <!-- Harga Satuan-->
        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp):</label>
            <input type="text" class="form-control" id="harga_format" autocomplete="off" required>
            <input type="hidden" name="harga_satuan" id="harga_satuan" required> <!-- Input hidden untuk menyimpan angka asli -->
            <div class="form-text">Masukkan harga dalam angka, maksimal 10 digit</div>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('suku-cadang.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <!-- JavaScript untuk format angka dan validasi -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const hargaFormat = document.getElementById("harga_format");
            const hargaInput = document.getElementById("harga_satuan");

            hargaFormat.addEventListener("input", function (e) {
                let value = this.value.replace(/\D/g, ""); // Hapus semua karakter non-angka
                if (value.length > 10) {
                    value = value.slice(0, 10); // Batasi maksimal 10 digit
                }
                
                hargaInput.value = value; // Simpan angka asli di input hidden
                this.value = formatRupiah(value); // Format tampilan sebagai rupiah
            });

            function formatRupiah(angka) {
                return angka.replace(/\B(?=(\d{3})+(?!\d))/g, "."); // Format angka dengan titik
            }
        });
    </script>
@endsection
