<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mekanik;

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

        Mekanik::create($request->all());
        return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil ditambahkan.');
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

        $mekanik->update($request->all());
        return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mekanik $mekanik)
    {
        $mekanik->delete();
        return redirect()->route('mekanik.index')->with('success', 'Data Mekanik berhasil dihapus.');
    }
}
