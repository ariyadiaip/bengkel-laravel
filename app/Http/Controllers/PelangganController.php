<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Pelanggan::with('kendaraan');

        if ($search) {
            $query->where('nama_pelanggan', 'like', "%$search%")
                ->orWhere('no_telepon', 'like', "%$search%")
                ->orWhereHas('kendaraan', function ($q) use ($search) {
                    $q->where('model', 'like', "%$search%")
                      ->orWhere('no_polisi', 'like', "%$search%");
                });
        }

        $pelanggans = $query->paginate(10);

        return view('pelanggan.index', compact('pelanggans', 'search'));

    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:30',
            'alamat' => 'required|string|max:50',
            'no_telepon' => 'required|string|max:15',
            'kendaraan' => 'array|required',
            'kendaraan.*.no_polisi' => 'required|string|max:11|unique:kendaraan,no_polisi',
            'kendaraan.*.tipe' => 'required|string|max:10',
            'kendaraan.*.model' => 'required|string|max:20',
            'kendaraan.*.tahun' => 'required|digits:4',
        ]);

        DB::beginTransaction();
        try {
            // Simpan data pelanggan
            $pelanggan = Pelanggan::create($request->only(['nama_pelanggan', 'alamat', 'no_telepon']));

            // Simpan data kendaraan terkait
            foreach ($request->kendaraan as $kendaraan) {
                $pelanggan->kendaraan()->create($kendaraan);
            }

            DB::commit(); // Simpan permanen jika semua sukses
            Log::info("Admin [" . auth()->user()->email . "] menambah pelanggan & kendaraan: " . $pelanggan->nama_pelanggan);

            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
        } catch (Exception $e) {
            DB::rollBack(); // Batalkan semua jika ada satu saja yang gagal
            Log::error("Gagal tambah pelanggan: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat menyimpan data.');
        }
        
        
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load('kendaraan');
        return view('pelanggan.detail', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        $pelanggan->load('kendaraan');
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:30',
            'alamat' => 'required|string|max:50',
            'no_telepon' => 'required|string|max:15',
            'kendaraan' => 'array|required',
            'kendaraan.*.no_polisi' => 'required|string|max:11',
            'kendaraan.*.tipe' => 'required|string|max:10',
            'kendaraan.*.model' => 'required|string|max:20',
            'kendaraan.*.tahun' => 'required|digits:4',
        ]);

        DB::beginTransaction();
        try {
            // Update pelanggan
            $pelanggan->update($request->only(['nama_pelanggan', 'alamat', 'no_telepon']));

            // Hapus kendaraan lama & tambahkan yang baru
            $pelanggan->kendaraan()->delete();
            foreach ($request->kendaraan as $kendaraan) {
                $pelanggan->kendaraan()->create($kendaraan);
            }

            DB::commit();
            Log::info("Admin [" . auth()->user()->email . "] memperbarui data pelanggan ID: " . $pelanggan->id_pelanggan);

            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal update pelanggan ID " . $pelanggan->id_pelanggan . ": " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    public function destroy(Pelanggan $pelanggan)
    {
        DB::beginTransaction();
        try {
            $nama = $pelanggan->nama_pelanggan;
            $pelanggan->kendaraan()->delete();
            $pelanggan->delete();
    
            DB::commit();
            Log::warning("Admin [" . auth()->user()->email . "] menghapus data pelanggan: " . $nama);

            return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Gagal hapus pelanggan: " . $e->getMessage());
            return back()->with('error', 'Data gagal dihapus karena masih terkait dengan transaksi aktif.');
        }
    }
}
