<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 20px; 
            background-color: #f8f9fa; /* Latar belakang abu-abu */
        }
        
        .container {
            width: 80%; /* Ukuran kuitansi */
            margin: 0 auto; /* Tengah */
            padding: 20px;
            border: 2px solid black; /* Garis batas */
            border-radius: 10px; /* Sudut melengkung */
            background-color: white; /* Latar kuitansi */
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }

        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .no-border { border: none; }

        /* Tombol Kembali & Print */
        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .btn-back {
            background-color: #6c757d;
            color: white;
        }

        .btn-print {
            background-color: #007bff;
            color: white;
        }

        /* Saat Print, sembunyikan tombol */
        @media print {
            .button-container {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- ===== HEADER ===== -->
        <h2 class="text-center">KUITANSI</h2>
        <table class="no-border">
            <tr>
                <td class="no-border">
                    <h3>CV. TRIDJAYA MERDEKA SUKSES</h3>
                    <p>JL. MERDEKA NO 51</p>
                    <p>087999999999</p>
                    <p><span style="display: inline-block; width: 150px;">NPWP</span>: {{ $transaksi->mekanik->npwp ?? ' ' }}</p>
                    <p><span style="display: inline-block; width: 150px;">Mekanik</span>: {{ $transaksi->mekanik->nama_mekanik }}</p>
                </td>
                <td class="no-border text-right">
                    <p><strong>No. Kuitansi:</strong> {{ $transaksi->no_kuitansi }}</p>
                    <p><strong>Kembali Service:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->locale('id')->translatedFormat('d F Y') }}</p>
                </td>
            </tr>
        </table>

        <hr>

        <!-- ===== DATA PELANGGAN & KENDARAAN ===== -->
        <table>
            <tr>
                <td><strong>Nama Customer</strong></td>
                <td>: {{ $transaksi->kendaraan->pelanggan->nama_pelanggan }}</td>
                <td class="text-right"></td>
                <td class="text-right"> <strong>Alamat</strong> : {{ $transaksi->kendaraan->pelanggan->alamat }}</td>
            </tr>
            <tr>
                <td><strong>No. Polisi</strong></td>
                <td>: {{ $transaksi->kendaraan->no_polisi }}</td>
            </tr>
            <tr>
                <td><strong>No. Work Order</strong></td>
                <td>: {{ $transaksi->no_work_order }}</td>
            </tr>
        </table>

        <hr>

        <!-- ===== JASA BENGKEL ===== -->
        <h4>Jasa Bengkel</h4>
        <table>
            <tr>
                <th width="15%">ID Jasa</th>
                <th width="25%">Nama Jasa Bengkel</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="15%" class="text-right">Harga Satuan</th>
                <th width="15%" class="text-right">Diskon</th>
                <th width="20%" class="text-right">Harga Setelah Diskon</th>
            </tr>
            @foreach($transaksi->detailJasa as $jasa)
            <tr>
                <td>{{ $jasa->id_jasa }}</td>
                <td>{{ $jasa->jasa->nama_jasa }}</td>
                <td class="text-center">{{ $jasa->qty }}</td>
                <td class="text-right">Rp {{ number_format($jasa->jasa->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($jasa->diskon, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($jasa->harga_setelah_diskon, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5"></td>
                <td><hr></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right"><strong>Total Jasa:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksi->detailJasa->sum('harga_setelah_diskon'), 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <!-- ===== SUKU CADANG ===== -->
        <h4>Suku Cadang</h4>
        <table>
            <tr>
                <th width="15%">ID Suku Cadang</th>
                <th width="25%">Nama Suku Cadang</th>
                <th width="10%" class="text-center">Qty</th>
                <th width="15%" class="text-right">Harga Satuan</th>
                <th width="15%" class="text-right">Diskon</th>
                <th width="20%" class="text-right">Harga Setelah Diskon</th>
            </tr>
            @foreach($transaksi->detailSukuCadang as $sukuCadang)
            <tr>
                <td>{{ $sukuCadang->id_suku_cadang }}</td>
                <td>{{ $sukuCadang->sukuCadang->nama_suku_cadang }}</td>
                <td class="text-center">{{ $sukuCadang->qty }}</td>
                <td class="text-right">Rp {{ number_format($sukuCadang->sukuCadang->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($sukuCadang->diskon, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($sukuCadang->harga_setelah_diskon, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5"></td>
                <td><hr></td>
            </tr>
            <tr>
                <td colspan="5" class="text-right"><strong>Total Suku Cadang:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($transaksi->detailSukuCadang->sum('harga_setelah_diskon'), 0, ',', '.') }}</strong></td>
            </tr>
        </table>

        <hr>

        <!-- ===== GRAND TOTAL ===== -->
        <table class="no-border">
            <tr>
                <td class="no-border" colspan="3"></td> <!-- Spasi kosong untuk meratakan -->
                <td class="text-right no-border"><strong>Total Diskon:</strong></td>
                <td class="text-right no-border">
                    Rp {{ number_format($transaksi->detailJasa->sum('diskon') + $transaksi->detailSukuCadang->sum('diskon'), 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td class="no-border" colspan="3" rowspan="2" style="vertical-align: top;">
                    <strong>TERBILANG:</strong> {{ strtoupper(App\Helpers\Terbilang::convert($transaksi->grand_total)) }} RUPIAH
                </td>
                <td class="text-right no-border"><strong>GRAND TOTAL:</strong></td>
                <td class="text-right no-border">
                    <strong>Rp {{ number_format($transaksi->grand_total, 0, ',', '.') }}</strong>
                </td>
            </tr>
        </table>

        <!-- ===== FOOTER ===== -->
        <table class="no-border" style="width: 100%;">
            <tr>
                <td class="no-border" style="vertical-align: top; width: 60%;">
                    <strong>Saran Mekanik:</strong>
                    <p>{{ $transaksi->saran_mekanik ?? '-' }}</p>
                    <p><strong>Catatan:</strong></p>
                    <ul>
                        <li>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</li>
                        <li>Part bekas adalah hak konsumen</li>
                        <li>Garansi 7 hari dari tanggal service / 500 km</li>
                        <li>Garansi turun mesin 1 bulan / 1000 km</li>
                    </ul>
                </td>

                <td class="no-border text-center" style="width: 40%;">
                    <br><br><br>
                    <p class="text-center">KOTA BANDUNG, {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->locale('id')->translatedFormat('d F Y') }}</p>
                    <!-- Ruang untuk TTD -->
                    <table style="width: 100%;">
                        <tr>
                            <td class="text-center">
                                <strong>Kasir</strong><br><br><br><br><br>
                                <hr>
                                {{ config('app.cashier_name', 'NAMA KASIR') }}
                            </td>
                            <td class="text-center">
                                <strong>Customer</strong><br><br><br><br><br>
                                <hr>
                                {{ $transaksi->kendaraan->pelanggan->nama_pelanggan }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- ===== CAP LUNAS (DITAMPILKAN JIKA LUNAS) ===== -->
        @if($transaksi->status_pembayaran === 'Lunas')
            <div style="text-align: center; margin-top: 20px;">
                <img src="{{ asset('assets/images/cap_lunas.png') }}" alt="LUNAS" style="width: 150px; opacity: 0.8;">
            </div>
        @endif

        <hr>
    </div> <!-- END CONTAINER -->

    <!-- Tombol Kembali dan Print -->
    <div class="button-container" style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; margin-right: 120px">
        <a href="{{ route('cek-kuitansi') }}" class="btn btn-secondary me-2 btn-back">Kembali</a>
        <button class="btn btn-primary btn-print" onclick="window.print();">Print</button>
    </div>
</body>
</html>
