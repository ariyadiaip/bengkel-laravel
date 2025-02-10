<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggan;
use App\Models\Kendaraan;

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

        // Simpan data pelanggan
        $pelanggan = Pelanggan::create($request->only(['nama_pelanggan', 'alamat', 'no_telepon']));

        // Simpan data kendaraan terkait
        foreach ($request->kendaraan as $kendaraan) {
            $pelanggan->kendaraan()->create($kendaraan);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan.');
        
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

        // Update pelanggan
        $pelanggan->update($request->only(['nama_pelanggan', 'alamat', 'no_telepon']));

        // Hapus kendaraan lama & tambahkan yang baru
        $pelanggan->kendaraan()->delete();
        foreach ($request->kendaraan as $kendaraan) {
            $pelanggan->kendaraan()->create($kendaraan);
        }

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->kendaraan()->delete();
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus.');
    }
}
