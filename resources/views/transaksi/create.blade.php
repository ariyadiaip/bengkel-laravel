@extends('layouts.app')

@section('content')
<h2>Tambah Transaksi</h2>
<br>

<form action="{{ route('transaksi.store') }}" method="POST">
    @csrf

    <!-- Pilih Pelanggan -->
    <div class="mb-3">
        <label for="search_pelanggan" class="form-label">Pilih Pelanggan:</label>
        <input type="text" class="form-control" id="search_pelanggan" placeholder="Cari pelanggan..." autocomplete="off" required>
        <input type="hidden" name="id_pelanggan" id="id_pelanggan">
        <input type="hidden" name="id_kendaraan" id="id_kendaraan">
        <div id="dropdown_pelanggan" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
    </div>

    <div id="kendaraan_section" class="mb-3" style="display: none;">
        <h5>Data Kendaraan</h5>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>No Polisi</th>
                        <th>Model</th>
                        <th>Tipe</th>
                        <th>Tahun</th>
                    </tr>
                </thead>
                <tbody id="kendaraan_list"></tbody>
            </table>
        </div>
    </div>

    <!-- Pilih Mekanik -->
    <div class="mb-3">
        <label for="search_mekanik" class="form-label">Pilih Mekanik:</label>
        <input type="text" class="form-control" id="search_mekanik" placeholder="Cari mekanik..." autocomplete="off" required>
        <input type="hidden" name="id_mekanik" id="id_mekanik">
        <div id="dropdown_mekanik" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
    </div>

    <hr>

    <!-- Pilih Jasa -->
    <h4>Pilih Jasa</h4>
    <div class="mb-3">
        <input type="text" class="form-control" id="search_jasa" placeholder="Cari jasa..." autocomplete="off">
        <div id="dropdown_jasa" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
    </div>

    <table class="table" id="tableJasa">
        <thead>
            <tr>
                <th>Jasa</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <hr>

    <!-- Pilih Suku Cadang -->
    <h4>Pilih Suku Cadang</h4>
    <div class="mb-3">
        <input type="text" class="form-control" id="search_suku_cadang" placeholder="Cari suku cadang..." autocomplete="off">
        <div id="dropdown_suku_cadang" class="dropdown-menu w-100" style="max-height: 200px; overflow-y: auto;"></div>
    </div>

    <table class="table" id="tableSukuCadang">
        <thead>
            <tr>
                <th>Suku Cadang</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Diskon</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <hr>

    <div class="row">
        <!-- Input Saran Mekanik -->
        <div class="col-md-6">
            <div class="mb-3">
                <label for="saran_mekanik" class="form-label">Saran Mekanik (Opsional):</label>
                <textarea name="saran_mekanik" id="saran_mekanik" class="form-control" rows="2" placeholder="Masukkan saran..."></textarea>
            </div>
        </div>

        <!-- Total Harga -->
        <div class="col-md-6 text-end">
            <h4>Subtotal: Rp <span id="subtotalHarga">0</span></h4>
            <h4>Diskon ({{ $configDiskon }}%): Rp <span id="diskonHarga">0</span></h4>
            <h4><strong>Total: Rp <span id="totalHarga">0</span></strong></h4>
        </div>
    </div>

    <!-- Tombol Submit -->
    <div class="d-flex justify-content-end">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-2">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {

        let jasaData = @json($jasas);
        let sukuCadangData = @json($sukuCadangs);
        let pelangganData = @json($pelanggans);
        let mekanikData = @json($mekaniks);
        let diskonPersen = {{ $configDiskon }};
        
        function setupSearch(inputId, dropdownId, dataList, callback) {
            const input = document.getElementById(inputId);
            const dropdown = document.getElementById(dropdownId);

            input.addEventListener("input", function () {
                let inputValue = this.value.toLowerCase();
                dropdown.innerHTML = "";
                dropdown.classList.add("show");

                let filteredData = dataList.filter(item => {
                    let itemName = item.nama || item.nama_pelanggan || item.nama_mekanik || item.nama_jasa || item.nama_suku_cadang;
                    return itemName && itemName.toLowerCase().includes(inputValue);
                });

                if (filteredData.length === 0) {
                    dropdown.innerHTML = `<div class="dropdown-item text-muted">Tidak ditemukan</div>`;
                    return;
                }

                filteredData.forEach(item => {
                    let itemName = item.nama || item.nama_pelanggan || item.nama_mekanik || item.nama_jasa || item.nama_suku_cadang;
                    let dropdownItem = document.createElement("div");
                    dropdownItem.classList.add("dropdown-item");
                    dropdownItem.textContent = itemName;
                    dropdownItem.onclick = function () {
                        callback(item);
                        dropdown.classList.remove("show");
                    };
                    dropdown.appendChild(dropdownItem);
                });

                positionDropdown(input, dropdown);
            });

            document.addEventListener("click", function (event) {
                if (!input.contains(event.target) && !dropdown.contains(event.target)) {
                    dropdown.classList.remove("show");
                }
            });
        }


        setupSearch("search_pelanggan", "dropdown_pelanggan", pelangganData, function (pelanggan) {
            document.getElementById("search_pelanggan").value = pelanggan.nama_pelanggan;
            document.getElementById("id_pelanggan").value = pelanggan.id_pelanggan;
            fetch(`/api/get-kendaraan/${pelanggan.id_pelanggan}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.id_kendaraan) {
                        document.getElementById("id_kendaraan").value = data.id_kendaraan;

                        document.getElementById("kendaraan_list").innerHTML = `
                            <tr>
                                <td>${data.no_polisi}</td>
                                <td>${data.model}</td>
                                <td>${data.tipe}</td>
                                <td>${data.tahun}</td>
                            </tr>
                        `;
                        document.getElementById("kendaraan_section").style.display = "block";
                    } else {
                        console.warn("Tidak ada kendaraan untuk pelanggan ini");
                        document.getElementById("kendaraan_list").innerHTML = `<tr><td colspan="4" class="text-center">Tidak ada kendaraan</td></tr>`;
                        document.getElementById("kendaraan_section").style.display = "block";
                    }
                }).catch(error => {
                    console.error("Error fetching kendaraan:", error);
                });
        });

        setupSearch("search_mekanik", "dropdown_mekanik", mekanikData, function (mekanik) {
            document.getElementById("search_mekanik").value = mekanik.nama_mekanik;
            document.getElementById("id_mekanik").value = mekanik.id_mekanik;
        });

        setupSearch("search_jasa", "dropdown_jasa", jasaData, function (jasa) {
            let harga = parseInt(jasa.harga_satuan);
            let qty = 1;
            let diskon = (harga * qty * diskonPersen) / 100;
            let total = (harga * qty) - diskon;

            const tbody = document.querySelector("#tableJasa tbody");
            tbody.innerHTML += `
                <tr>
                    <td><input type="hidden" name="jasa[]" value="${jasa.id_jasa}">${jasa.nama_jasa}</td>
                    <td class="hargaJasa">Rp ${harga.toLocaleString("id-ID")}</td>
                    <td>1 <input type="hidden" name="qty_jasa[]" value="1"></td>
                    <td class="diskonJasa">Rp ${diskon.toLocaleString("id-ID")}</td>
                    <td class="totalJasa">Rp ${total.toLocaleString("id-ID")}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
                </tr>`;
            updateTotal();
        });

        setupSearch("search_suku_cadang", "dropdown_suku_cadang", sukuCadangData, function (sc) {
            let diskonPersen = {{ $configDiskon }}; // Ambil dari konfigurasi
            let harga = parseInt(sc.harga_satuan);
            let qty = 1;
            let diskon = (harga * qty * diskonPersen) / 100;
            let total = (harga * qty) - diskon;

            const tbody = document.querySelector("#tableSukuCadang tbody");
            tbody.innerHTML += `
                <tr>
                    <td><input type="hidden" name="suku_cadang[]" value="${sc.id_suku_cadang}">${sc.nama_suku_cadang}</td>
                    <td class="hargaSukuCadang">Rp ${harga.toLocaleString("id-ID")}</td>
                    <td><input type="number" name="qty_suku_cadang[]" value="1" min="1" class="qtySukuCadang" data-harga="${harga}" style="width: 50px;"></td>
                    <td class="diskonSukuCadang">Rp ${diskon.toLocaleString("id-ID")}</td>
                    <td class="totalSukuCadang">Rp ${total.toLocaleString("id-ID")}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-item">Hapus</button></td>
                </tr>`;
            updateTotal();
        });


        document.addEventListener("click", function (e) {
            if (e.target.classList.contains("remove-item")) {
                e.target.closest("tr").remove();
                updateTotal();
            }
        });

        document.addEventListener("input", function (e) {
            if (e.target.classList.contains("qtySukuCadang")) {
                let diskonPersen = {{ $configDiskon }};
                let row = e.target.closest("tr");
                let harga = parseInt(e.target.dataset.harga);
                let qty = parseInt(e.target.value);
                let diskonCell = row.querySelector(".diskonSukuCadang");
                let totalCell = row.querySelector(".totalSukuCadang");

                let diskon = (harga * qty * diskonPersen) / 100;
                let total = (harga * qty) - diskon;

                diskonCell.innerText = `Rp ${diskon.toLocaleString("id-ID")}`;
                totalCell.innerText = `Rp ${total.toLocaleString("id-ID")}`;

                updateTotal();
            }
        });

        document.getElementById("id_pelanggan").addEventListener("change", function () {
            let pelangganId = this.value;

            if (!pelangganId) {
                console.error("Pelanggan belum dipilih");
                return;
            }

            fetch(`/api/get-kendaraan/${pelangganId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.id_kendaraan) {
                        document.getElementById("id_kendaraan").value = data.id_kendaraan;

                        document.getElementById("kendaraan_list").innerHTML = `
                            <tr>
                                <td>${data.no_polisi}</td>
                                <td>${data.model}</td>
                                <td>${data.tipe}</td>
                                <td>${data.tahun}</td>
                            </tr>
                        `;
                        console.error("NAW belum dipilih");
                        document.getElementById("kendaraan_section").style.display = "block";
                    } else {
                        console.warn("Tidak ada kendaraan untuk pelanggan ini");
                        document.getElementById("kendaraan_list").innerHTML = `<tr><td colspan="4" class="text-center">Tidak ada kendaraan</td></tr>`;
                        document.getElementById("kendaraan_section").style.display = "block";
                    }
                })
                .catch(error => {
                    console.error("Error fetching kendaraan:", error);
                });
        });


        function updateTotal() {
            let subtotal = 0;
            let totalDiskon = 0;

            document.querySelectorAll("tr").forEach((row) => {
                let totalCell = row.querySelector(".hargaJasa, .hargaSukuCadang");
                let diskonCell = row.querySelector(".diskonJasa, .diskonSukuCadang");

                if (totalCell) {
                    subtotal += parseInt(totalCell.innerText.replace(/\D/g, "")) || 0;
                }
                if (diskonCell) {
                    totalDiskon += parseInt(diskonCell.innerText.replace(/\D/g, "")) || 0;
                }
            });

            let total = subtotal - totalDiskon; // Tidak perlu dikurangi lagi

            document.getElementById("subtotalHarga").innerText = subtotal.toLocaleString("id-ID");
            document.getElementById("diskonHarga").innerText = totalDiskon.toLocaleString("id-ID");
            document.getElementById("totalHarga").innerText = total.toLocaleString("id-ID");
        }

        function positionDropdown(input, dropdown) {
            let rect = input.getBoundingClientRect();
            let maxWidth = document.documentElement.clientWidth - rect.left; // Mencegah keluar layar

            dropdown.style.position = "absolute";
            dropdown.style.width = Math.min(input.offsetWidth, maxWidth) + "px"; // Pastikan tidak keluar layar
            dropdown.style.top = rect.bottom + window.scrollY + "px";
            dropdown.style.left = rect.left + window.scrollX + "px";
        }

    });

</script>
@endsection
