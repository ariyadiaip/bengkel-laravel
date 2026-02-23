<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SukuCadang;
use Illuminate\Support\Facades\Log;
use Exception;

class SukuCadangController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $suku_cadangs = SukuCadang::all();
    //     return view('suku-cadang.index', compact('suku_cadangs'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = SukuCadang::query();

        if ($search) {
            $query->where('id_suku_cadang', 'like', "%$search%")
                ->orWhere('nama_suku_cadang', 'like', "%$search%")
                ->orWhere('harga_satuan', 'like', "%$search%");
        }

        $suku_cadangs = $query->paginate(10);
        return view('suku-cadang.index', compact('suku_cadangs', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('suku-cadang.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_suku_cadang' => 'required|string|max:30',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        try{
            $request->merge([
                'nama_suku_cadang' => strtoupper($request->nama_suku_cadang), // Ubah jadi kapital
            ]);

            SukuCadang::create($request->all());
            Log::info("Admin [" . auth()->user()->email . "] menambah stok suku cadang: " . $request->nama_suku_cadang);
            return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal simpan suku cadang: " . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan data suku cadang.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SukuCadang $sukuCadang)
    {
        return view('suku-cadang.detail', compact('sukuCadang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SukuCadang $sukuCadang)
    {
        return view('suku-cadang.edit', compact('sukuCadang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SukuCadang $sukuCadang)
    {
        $request->validate([
            'nama_suku_cadang' => 'required|string|max:30',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            $request->merge([
                'nama_suku_cadang' => strtoupper($request->nama_suku_cadang), // Ubah jadi kapital
            ]);

            $sukuCadang->update($request->all());
            Log::info("Admin [" . auth()->user()->email . "] memperbarui suku cadang ID: " . $sukuCadang->id_suku_cadang);
            return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal update suku cadang ID " . $sukuCadang->id_suku_cadang . ": " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SukuCadang $sukuCadang)
    {
        try {
            $namaSukuCadang = $sukuCadang->nama_suku_cadang;
            $sukuCadang->delete();

            Log::warning("Admin [" . auth()->user()->email . "] menghapus suku cadang: " . $namaSukuCadang);

            return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil dihapus.');
        } catch (Exception $e) {
            Log::error("Gagal hapus suku cadang: " . $e->getMessage());
            return back()->with('error', 'Data gagal dihapus. Suku cadang ini mungkin sudah tercatat dalam transaksi.');
        }
    }
}
