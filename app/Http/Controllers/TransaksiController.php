<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Mekanik;
use App\Models\Jasa;
use App\Models\SukuCadang;
use App\Models\DetailTransaksiJasa;
use App\Models\DetailTransaksiSukuCadang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $transaksi = Transaksi::all();
    //     return view('transaksi.index', compact(''));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $sort = $request->input('sort', 'desc'); // Default urutan terbaru

        $transaksi = Transaksi::when($search, function ($query, $search) {
            return $query->where('id_transaksi', 'like', "%$search%")
                         ->orWhere('no_kuitansi', 'like', "%$search%")
                         ->orWhere('tanggal_transaksi', 'like', "%$search%")
                         ->orWhere('grand_total', 'like', "%$search%")
                         ->orWhere('status_pembayaran', 'like', "%$search%");
        })->orderBy('no_kuitansi', $sort)->paginate(10);

        return view('transaksi.index', compact('transaksi', 'search', 'sort'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::with('kendaraan')->get();
        $mekaniks = Mekanik::all();
        $jasas = Jasa::all();
        $sukuCadangs = SukuCadang::all();
        $configDiskon = config('app.default_discount');

        return view('transaksi.create', compact('pelanggans', 'mekaniks', 'jasas', 'sukuCadangs', 'configDiskon'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $tanggal_transaksi = Carbon::now()->toDateString();
            $tanggal_kembali = DB::selectOne("SELECT nextServiceDate(?) AS tanggal_kembali", [$tanggal_transaksi])->tanggal_kembali;

            $configDiskon = config('app.default_discount');

            $saran_mekanik = $request->saran_mekanik ?? '-';

            $transaksi = Transaksi::create([
                'tanggal_transaksi' => $tanggal_transaksi,
                'tanggal_kembali' => $tanggal_kembali,
                'grand_total' => 0,
                'status_pembayaran' => 'Belum Lunas',
                'saran_mekanik' => $saran_mekanik,
                'id_mekanik' => $request->id_mekanik,
                'id_kendaraan' => $request->id_kendaraan,
            ]);

            $totalHarga = 0;

            if ($request->has('jasa')) {
                foreach ($request->jasa as $index => $id_jasa) {
                    $jasa = Jasa::findOrFail($id_jasa);
                    $qty = $request->qty_jasa[$index];

                    $subtotal = $jasa->harga_satuan * $qty;
                    $diskon = ($subtotal * $configDiskon) / 100;
                    $hargaSetelahDiskon = $subtotal - $diskon;

                    DetailTransaksiJasa::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_jasa' => $id_jasa,
                        'qty' => $qty,
                        'diskon' => $diskon,
                        'harga_setelah_diskon' => $hargaSetelahDiskon,
                    ]);

                    $totalHarga += $hargaSetelahDiskon;
                }
            }

            if ($request->has('suku_cadang')) {
                foreach ($request->suku_cadang as $index => $id_suku_cadang) {
                    $sukuCadang = SukuCadang::findOrFail($id_suku_cadang);
                    $qty = $request->qty_suku_cadang[$index];

                    $subtotal = $sukuCadang->harga_satuan * $qty;
                    $diskon = ($subtotal * $configDiskon) / 100;
                    $hargaSetelahDiskon = $subtotal - $diskon;

                    DetailTransaksiSukuCadang::create([
                        'id_transaksi' => $transaksi->id_transaksi,
                        'id_suku_cadang' => $id_suku_cadang,
                        'qty' => $qty,
                        'diskon' => $diskon,
                        'harga_setelah_diskon' => $hargaSetelahDiskon,
                    ]);

                    $totalHarga += $hargaSetelahDiskon;
                }
            }

            $transaksi->update(['grand_total' => $totalHarga]);

            DB::commit();
            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with([
            'kendaraan.pelanggan',
            'mekanik',
            'detailJasa.jasa',
            'detailSukuCadang.sukuCadang'
        ])->findOrFail($id);

        return view('transaksi.detail', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_pembayaran = $request->status_pembayaran;
        $transaksi->save();

        return redirect()->route('transaksi.show', $id)->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function updateStatusOnIndex(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Belum Lunas'
        ]);

        $transaksi = Transaksi::findOrFail($id);
        $transaksi->status_pembayaran = $request->status_pembayaran;
        $transaksi->save();

        return redirect()->route('transaksi.index', $id)->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Cari transaksi
            $transaksi = Transaksi::findOrFail($id);

            // Hapus detail transaksi jasa
            DetailTransaksiJasa::where('id_transaksi', $id)->delete();

            // Hapus detail transaksi suku cadang
            DetailTransaksiSukuCadang::where('id_transaksi', $id)->delete();

            // Hapus transaksi utama
            $transaksi->delete();

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('transaksi.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

}
