@extends('layouts.app')

@section('content')
<style>
@media print {
    @page {
        size: landscape;
        margin: 0;
    }

    body {
        margin: 0;
        padding: 1cm;
        visibility: hidden;
        -webkit-print-color-adjust: exact;
    }

    .d-print-block, 
    .d-print-block *,
    .card.mt-4, 
    .card.mt-4 * {
        visibility: visible;
    }

    .d-print-block {
        position: absolute;
        top: 1cm;
        left: 0;
        width: 100%;
        text-align: center;
        display: block !important;
    }

    .card.mt-4 {
        position: absolute;
        top: 4.5cm;
        left: 1cm;
        right: 1cm;
        width: calc(100% - 2cm) !important;
        border: none !important;
        box-shadow: none !important;
    }

    #chartPendapatan {
        width: 100% !important;
        height: 12cm !important;
    }

    .card-title.d-print-none {
        display: none !important;
    }
}
</style>
<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2>Dashboard</h2>
        
        <!-- Filter -->
        <form method="GET" class="d-flex align-items-end gap-2">
            <div>
                <label for="bulan" class="form-label">Filter Data:</label>
                <input type="month" name="bulan" id="bulan" class="form-control" value="{{ $bulan }}">
            </div>
            <div>
                <button type="submit" class="btn btn-primary">Tampilkan</button>
            </div>
            <div>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Reset</a>
            </div>
            <div>
                <button onclick="window.print()" class="btn btn-danger d-print-none">
                    <i class="fas fa-file-pdf"></i> Cetak PDF
                </button>
            </div>
        </form>
    </div>

    <div class="d-none d-print-block text-center mb-4">
        <h1 style="margin-bottom: 5px;">LAPORAN GRAFIK PENDAPATAN</h1>
        <h3 style="margin: 0; color: #444;">Tridjaya Merdeka Motor</h3>
        <p style="font-size: 14px; margin-top: 5px;">
            Periode: {{ $bulan ? \Carbon\Carbon::parse($bulan)->translatedFormat('F Y') : 'Semua Waktu' }}
        </p>
        <hr style="border: 1px solid #000;">
    </div>

    <!-- Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Jasa</h5>
                    <p class="card-text fs-4">{{ number_format($totalJasa) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Suku Cadang</h5>
                    <p class="card-text fs-4">{{ number_format($totalSukuCadang) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Total Transaksi</h5>
                    <p class="card-text fs-4">{{ number_format($totalTransaksi) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Pendapatan</h5>
                    <p class="card-text fs-4">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title d-print-none">Grafik Pendapatan</h5>
            <canvas id="chartPendapatan"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById('chartPendapatan').getContext('2d');

        // Data dari backend
        const rawLabels = {!! json_encode($chartData->pluck('tanggal')) !!};
        const rawPendapatan = {!! json_encode($chartData->pluck('total_pendapatan')) !!};
        const rawTransaksi = {!! json_encode($chartData->pluck('jumlah_transaksi')) !!};

        // Format tanggal menjadi "DD MMM YYYY"
        const formattedLabels = rawLabels.map(date => {
            const options = { day: 'numeric', month: 'long', year: 'numeric' };
            return new Date(date).toLocaleDateString('id-ID', options);
        });

        // Cek apakah ada data atau tidak
        const hasData = rawPendapatan.length > 0;

        // Data untuk Chart.js
        const chartData = {
            labels: formattedLabels,
            datasets: [
                {
                    label: 'Pendapatan (Rp)',
                    data: rawPendapatan,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }
            ]
        };

        const chartOptions = {
            responsive: true,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            let pendapatan = new Intl.NumberFormat('id-ID', {
                                style: 'currency',
                                currency: 'IDR'
                            }).format(tooltipItem.raw);

                            let transaksi = rawTransaksi[tooltipItem.dataIndex];

                            return [`Pendapatan: ${pendapatan}`, `Total Transaksi: ${transaksi}`];
                        }
                    }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        };

        // Jika tidak ada data, tampilkan pesan "Tidak Ada Transaksi"
        if (!hasData) {
            ctx.font = "16px Arial";
            ctx.fillStyle = "gray";
            ctx.textAlign = "center";
            ctx.fillText("Tidak Ada Transaksi", ctx.canvas.width / 2, ctx.canvas.height / 2);
        } else {
            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: chartOptions
            });
        }
    });
</script>

@endsection
