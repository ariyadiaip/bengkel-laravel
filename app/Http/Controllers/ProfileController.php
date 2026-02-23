<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Exception;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'photo.image' => 'File harus berupa gambar.',
            'photo.mimes' => 'Format harus jpeg, png, atau jpg.',
            'photo.max'   => 'Ukuran foto maksimal 2MB.',
        ]);

        try {
            $user->name = $request->name;

            // Implementasi Multimedia (Upload Foto)
            if ($request->hasFile('photo')) {
                // Hapus foto lama jika bukan default.png
                if ($user->photo && $user->photo !== 'default.png') {
                    $oldPath = public_path('images/users/' . $user->photo);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                }

                // Upload foto baru
                $fileName = time() . '.' . $request->photo->extension();
                $request->photo->move(public_path('images/users'), $fileName);
                $user->photo = $fileName;
            }

            $user->save();
            Log::info("User [" . $user->email . "] berhasil memperbarui profil dan foto.");

            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (Exception $e) {
            Log::error("Gagal update profil user " . $user->id . ": " . $e->getMessage());
            
            return back()->with('error', 'Terjadi kesalahan sistem saat memperbarui profil.');
        }
    }
}
