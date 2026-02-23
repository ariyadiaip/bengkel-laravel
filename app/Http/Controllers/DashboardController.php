<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jasa;
use App\Models\SukuCadang;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Ambil bulan dari filter, default ke bulan ini, jika kosong tampilkan semua data
            $bulan = $request->input('bulan', '');
            $query = Transaksi::query();

            if ($bulan) {
                $query->where('tanggal_transaksi', 'like', "$bulan%");
            }

            $totalJasa = Jasa::count();
            $totalSukuCadang = SukuCadang::count();
            $totalTransaksi = $query->count();
            $totalPendapatan = $query->sum('grand_total');

            $chartData = $query->selectRaw('DATE(tanggal_transaksi) as tanggal, SUM(grand_total) as total_pendapatan, COUNT(*) as jumlah_transaksi')
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            Log::info("Dashboard diakses oleh: " . auth()->user()->email . ($bulan ? " dengan filter bulan: $bulan" : ""));
            return view('dashboard.index', compact('totalJasa', 'totalSukuCadang', 'totalTransaksi', 'totalPendapatan', 'chartData', 'bulan'));
        } catch (\Exception $e) {
            Log::error("Gagal memuat data dashboard: " . $e->getMessage());

            return view('dashboard.index')->with('error', 'Terjadi kesalahan saat memuat data statistik.');
        }
    }
}
