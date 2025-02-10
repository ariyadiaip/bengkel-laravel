<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SukuCadang;

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

        $request->merge([
            'nama_suku_cadang' => strtoupper($request->nama_suku_cadang), // Ubah jadi kapital
        ]);

        SukuCadang::create($request->all());
        return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil ditambahkan.');
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

        $request->merge([
            'nama_suku_cadang' => strtoupper($request->nama_suku_cadang), // Ubah jadi kapital
        ]);

        $sukuCadang->update($request->all());
        return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SukuCadang $sukuCadang)
    {
        $sukuCadang->delete();
        return redirect()->route('suku-cadang.index')->with('success', 'Suku Cadang berhasil dihapus.');
    }
}
