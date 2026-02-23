<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jasa;
use Illuminate\Support\Facades\Log;
use Exception;

class JasaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // public function index()
    // {
    //     $jasas = Jasa::all();
    //     return view('jasa.index', compact('jasas'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Jasa::query();

        if ($search) {
            $query->where('id_jasa', 'like', "%$search%")
                ->orWhere('nama_jasa', 'like', "%$search%")
                ->orWhere('harga_satuan', 'like', "%$search%");
        }

        $jasas = $query->paginate(10);
        return view('jasa.index', compact('jasas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jasa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:30',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            $request->merge([
                'nama_jasa' => strtoupper($request->nama_jasa), // Ubah jadi kapital
            ]);

            Jasa::create($request->all());
            Log::info("Admin [" . auth()->user()->email . "] menambahkan jasa baru: " . $request->nama_jasa);
            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal tambah jasa: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat menambah data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Jasa $jasa)
    {
        return view('jasa.detail', compact('jasa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jasa $jasa)
    {
        return view('jasa.edit', compact('jasa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jasa $jasa)
    {
        $request->validate([
            'nama_jasa' => 'required|string|max:30',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        try {
            $request->merge([
                'nama_jasa' => strtoupper($request->nama_jasa), // Ubah jadi kapital
            ]);

            $jasa->update($request->all());
            Log::info("Admin [" . auth()->user()->email . "] memperbarui jasa ID: " . $jasa->id_jasa);
            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal update jasa ID " . $jasa->id_jasa . ": " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jasa $jasa)
    {
        try {
            $namaJasa = $jasa->nama_jasa;
            $jasa->delete();

            Log::warning("Admin [" . auth()->user()->email . "] menghapus jasa: " . $namaJasa);
            return redirect()->route('jasa.index')->with('success', 'Jasa berhasil dihapus.');

        } catch (Exception $e) {
            Log::error("Gagal hapus jasa: " . $e->getMessage());
            return back()->with('error', 'Data gagal dihapus. Pastikan data tidak sedang digunakan di transaksi lain.');
        }
    }
}
