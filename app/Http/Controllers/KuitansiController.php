<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Exception;

class KuitansiController extends Controller
{
    public function formCekKuitansi()
    {
        return view('kuitansi.input_kuitansi');
    }

    public function cekKuitansi(Request $request)
    {
        $request->validate([
            'no_kuitansi' => 'required|string'
        ]);

        try {
            $transaksi = Transaksi::where('no_kuitansi', $request->no_kuitansi)->first();

            // Cari transaksi dengan status "Lunas"
            // $transaksi = Transaksi::where('no_kuitansi', $request->no_kuitansi)
            //     ->where('status_pembayaran', 'Lunas')
            //     ->first();

            if (!$transaksi) {
                Log::warning("Pencarian kuitansi gagal. No: " . $request->no_kuitansi . " dari IP: " . $request->ip());
                return redirect()->route('cek-kuitansi')->with('error', 'Kuitansi tidak ditemukan.');
            }

            return redirect()->route('cek-kuitansi.detail', ['no_kuitansi' => $transaksi->no_kuitansi]);
        } catch (Exception $e) {
            Log::error("Sistem error saat cek kuitansi: " . $e->getMessage());
            return redirect()->route('cek-kuitansi')->with('error', 'Terjadi gangguan sistem, silakan coba lagi nanti.');
        }
    }

    public function detailKuitansi($no_kuitansi)
    {
        try {
            $transaksi = Transaksi::with([
                'kendaraan.pelanggan',
                'mekanik',
                'detailJasa.jasa',
                'detailSukuCadang.sukuCadang'
            ])->where('no_kuitansi', $no_kuitansi)->first();

            if (!$transaksi) {
                return redirect('/cek-kuitansi')->with('error', 'Kuitansi tidak ditemukan!');
            }
            Log::info("Kuitansi #" . $no_kuitansi . " berhasil dilihat oleh publik (IP: " . request()->ip() . ")");
            return view('kuitansi.detail_kuitansi', compact('transaksi'));
        } catch (Exception $e) {
            Log::error("Error saat memuat detail kuitansi: " . $e->getMessage());
            return redirect('/cek-kuitansi')->with('error', 'Gagal memuat detail kuitansi.');
        }
    }

}
