@extends('layouts.app')

@section('content')
    <h2>Edit Data Pelanggan</h2>
    <br>

    <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Nama Pelanggan & No Telepon -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_pelanggan" class="form-label">Nama Pelanggan:</label>
                <input type="text" class="form-control" name="nama_pelanggan" id="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" maxlength="30" autocomplete="off" required>
                <div class="form-text">Maksimal 30 karakter</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="no_telepon" class="form-label">No Telepon:</label>
                <input type="text" class="form-control" name="no_telepon" id="no_telepon" value="{{ old('no_telepon', $pelanggan->no_telepon) }}"  maxlength="15" autocomplete="off" pattern="\d*" title="Hanya angka yang diperbolehkan" required>
                <div class="form-text">Maksimal 15 digit (hanya angka)</div>
            </div>
        </div>

        <!-- Alamat -->
        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" name="alamat" id="alamat" rows="2" maxlength="50" autocomplete="off" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
            <div class="form-text">Maksimal 50 karakter</div>
        </div>

        <hr class="my-4">

        <h4>Data Kendaraan</h4>

        <!-- No Polisi & Tipe -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="no_polisi" class="form-label">Nomor Polisi:</label>
                <input type="text" class="form-control" name="kendaraan[0][no_polisi]" id="no_polisi" value="{{ old('kendaraan.0.no_polisi', $pelanggan->kendaraan[0]->no_polisi) }}" maxlength="11" autocomplete="off" required>
                <div class="form-text">Maksimal 11 karakter</div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="tipe" class="form-label">Tipe Kendaraan:</label>
                <select class="form-control" name="kendaraan[0][tipe]" id="tipe" required>
                    <option value="" disabled>Pilih Tipe Kendaraan</option>
                    <option value="Matic" {{ old('kendaraan.0.tipe', $pelanggan->kendaraan[0]->tipe) == 'Matic' ? 'selected' : '' }}>Matic</option>
                    <option value="Sport" {{ old('kendaraan.0.tipe', $pelanggan->kendaraan[0]->tipe) == 'Sport' ? 'selected' : '' }}>Sport</option>
                    <option value="Cub" {{ old('kendaraan.0.tipe', $pelanggan->kendaraan[0]->tipe) == 'Cub' ? 'selected' : '' }}>Cub</option>
                    <option value="EV" {{ old('kendaraan.0.tipe', $pelanggan->kendaraan[0]->tipe) == 'EV' ? 'selected' : '' }}>EV</option>
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
                    @for ($year = 2010; $year <= 2025; $year++)
                        <option value="{{ $year }}" {{ old('kendaraan.0.tahun', $pelanggan->kendaraan[0]->tahun) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Tombol Update dan Batal -->
        <div class="d-flex justify-content-end">
            <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Update</button>
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

            function updateModelOptions(selectedTipe, selectedModel = null) {
                modelSelect.innerHTML = '<option value="" disabled selected>Pilih Model Kendaraan</option>';

                if (selectedTipe in modelOptions) {
                    modelOptions[selectedTipe].forEach(model => {
                        const option = document.createElement("option");
                        option.value = model;
                        option.textContent = model;
                        if (selectedModel === model) {
                            option.selected = true;
                        }
                        modelSelect.appendChild(option);
                    });
                }
            }

            // Ambil data tipe dan model dari Laravel (blade template)
            const selectedTipe = "{{ old('kendaraan.0.tipe', $pelanggan->kendaraan[0]->tipe) }}";
            const selectedModel = "{{ old('kendaraan.0.model', $pelanggan->kendaraan[0]->model) }}";

            // Set model sesuai tipe kendaraan yang ada saat edit
            updateModelOptions(selectedTipe, selectedModel);
        });
    </script>

@endsection
