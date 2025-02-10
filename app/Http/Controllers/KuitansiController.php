<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

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

        $transaksi = Transaksi::where('no_kuitansi', $request->no_kuitansi)->first();

        // Cari transaksi dengan status "Lunas"
        // $transaksi = Transaksi::where('no_kuitansi', $request->no_kuitansi)
        //     ->where('status_pembayaran', 'Lunas')
        //     ->first();

        if (!$transaksi) {
            return redirect()->route('cek-kuitansi')->with('error', 'Kuitansi tidak ditemukan.');
        }

        return redirect()->route('cek-kuitansi.detail', ['no_kuitansi' => $transaksi->no_kuitansi]);
    }

    public function detailKuitansi($no_kuitansi)
    {
        $transaksi = Transaksi::with([
            'kendaraan.pelanggan',
            'mekanik',
            'detailJasa.jasa',
            'detailSukuCadang.sukuCadang'
        ])->where('no_kuitansi', $no_kuitansi)->first();

        if (!$transaksi) {
            return redirect('/cek-kuitansi')->with('error', 'Kuitansi tidak ditemukan!');
        }

        return view('kuitansi.detail_kuitansi', compact('transaksi'));
    }

}
