@extends('layouts.app')

@section('content')
    <h2>Tambah Data Pelanggan</h2>
    <br>

    <form action="{{ route('pelanggan.store') }}" method="POST">
        @csrf

        <!-- Nama Pelanggan & No Telepon -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan:</label>
                <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" maxlength="30" autocomplete="off" required>
                <div class="form-text">Maksimal 30 karakter</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="no_telepon" class="form-label">No Telepon:</label>
                <input type="text" class="form-control" name="no_telepon" id="no_telepon" maxlength="15" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan" required>
                <div class="form-text">Maksimal 15 digit (hanya angka)</div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="2" maxlength="50" autocomplete="off" required></textarea>
            <div class="form-text">Maksimal 50 karakter</div>
        </div>

        <hr class="my-4">

        <h4>Data Kendaraan</h4>

        <!-- No Polisi & Tipe -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="no_polisi" class="form-label">Nomor Polisi:</label>
                <input type="text" class="form-control" name="kendaraan[0][no_polisi]" id="no_polisi" maxlength="11" autocomplete="off" required>
                <div class="form-text">Maksimal 11 karakter</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipe" class="form-label">Tipe Kendaraan:</label>
                <select class="form-control" name="kendaraan[0][tipe]" id="tipe" required>
                    <option value="" disabled selected>Pilih Tipe Kendaraan</option>
                    <option value="Matic">Matic</option>
                    <option value="Sport">Sport</option>
                    <option value="Cub">Cub</option>
                    <option value="EV">EV</option>
                </select>
            </div>
        </div>

        <!-- Model Kendaraan & Tahun -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="model" class="form-label">Model Kendaraan:</label>
                <select class="form-control" name="kendaraan[0][model]" id="model" required>
                    <option value="" disabled selected>Pilih Model Kendaraan</option>
                </select>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="tahun" class="form-label">Tahun Kendaraan:</label>
                <select class="form-control" name="kendaraan[0][tahun]" id="tahun" required>
                    <option value="" disabled selected>Pilih Tahun Kendaraan</option>
                </select>
            </div>
        </div>

        <!-- Tombol Simpan dan Batal -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const tipeSelect = document.getElementById("tipe");
            const modelSelect = document.getElementById("model");

            const modelOptions = {
                Matic: ["BeAT", "BeAT Street", "Genio", "Scoopy", "Vario 125", "Vario 150", "Vario 160", "Stylo 160", "PCX 160", "ADV 160", "Forza"],
                Sport: ["CB150 Verza", "Sonic 150R", "CB150R Streetfire", "CB150X", "CRF150L", "CBR150R", "CBR250RR", "CRF250L", "ST125 Dax", "Monkey", "CRF250 RALLY"],
                Cub: ["Revo", "Supra X 125 FI", "GTR 150", "Supercub C125", "CT125"],
                EV: ["ICON e", "EM1 e", "EM1 e PLUS", "CUV e", "CUV e RoadsyncDuo"]
            };

            tipeSelect.addEventListener("change", function () {
                const selectedTipe = tipeSelect.value;
                modelSelect.innerHTML = '<option value="" disabled selected>Pilih Model Kendaraan</option>';

                if (selectedTipe in modelOptions) {
                    modelOptions[selectedTipe].forEach(model => {
                        const option = document.createElement("option");
                        option.value = model;
                        option.textContent = model;
                        modelSelect.appendChild(option);
                    });
                }
            });

            // Generate tahun untuk combobox
            const tahunSelect = document.getElementById("tahun");
            for (let year = 2010; year <= 2025; year++) {
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                tahunSelect.appendChild(option);
            }
        });
    </script>

@endsection
