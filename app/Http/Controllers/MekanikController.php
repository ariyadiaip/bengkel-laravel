<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mekanik;
use Illuminate\Support\Facades\Log;
use Exception;

class MekanikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
    // public function index()
    // {
    //     $mekaniks = Mekanik::all();
    //     return view('mekanik.index', compact('mekaniks'));
    // }

    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Mekanik::query();

        if ($search) {
            $query->where('nama_mekanik', 'like', "%$search%")
                ->orWhere('npwp', 'like', "%$search%")
                ->orWhere('no_telepon', 'like', "%$search%");
        }

        $mekaniks = $query->paginate(10); // 10 data per halaman

        return view('mekanik.index', compact('mekaniks', 'search'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mekanik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mekanik' => 'required|string|max:30',
            'npwp' => 'nullable|string|max:16',
            'no_telepon' => 'required|string|max:15',
        ]);

        try {
            Mekanik::create($request->all());
            Log::info("Admin [" . auth()->user()->email . "] menambah mekanik baru: " . $request->nama_mekanik);
            return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil ditambahkan.');
        } catch (Exception $e) {
            Log::error("Gagal tambah mekanik: " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan sistem saat menambah data.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Mekanik $mekanik)
    {
        return view('mekanik.detail', compact('mekanik'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mekanik $mekanik)
    {
        return view('mekanik.edit', compact('mekanik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mekanik $mekanik)
    {
        $request->validate([
            'nama_mekanik' => 'required|string|max:30',
            'npwp' => 'nullable|string|max:16',
            'no_telepon' => 'required|string|max:15',
        ]);

        try {
            $mekanik->update($request->all());
            Log::info("Admin [" . auth()->user()->email . "] memperbarui data mekanik ID: " . $mekanik->id_mekanik);
            return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil diperbarui.');
        } catch (Exception $e) {
            Log::error("Gagal update mekanik ID " . $mekanik->id_mekanik . ": " . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mekanik $mekanik)
    {
        try {
            $namaMekanik = $mekanik->nama_mekanik;
            $mekanik->delete();

            Log::warning("Admin [" . auth()->user()->email . "] menghapus data mekanik: " . $namaMekanik);
            return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil dihapus.');

        } catch (Exception $e) {
            Log::error("Gagal hapus mekanik: " . $e->getMessage());
            return back()->with('error', 'Data tidak bisa dihapus karena mungkin masih terikat dengan data transaksi.');
        }
    }
}
