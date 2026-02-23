<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');
        $logContent = [];

        if (File::exists($logPath)) {
            $file = file($logPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            
            $search = $request->input('search');
            $level = $request->input('level');

            foreach ($file as $line) {
                $matchSearch = empty($search) || str_contains(strtolower($line), strtolower($search));
                $matchLevel = empty($level) || str_contains($line, ".{$level}:");

                if ($matchSearch && $matchLevel) {
                    $logContent[] = $line;
                }
            }
            
            // Membalikkan urutan agar yang terbaru di atas
            $logContent = array_reverse($logContent);
        }

        $logContent = implode("\n", $logContent);

        return view('logs.index', compact('logContent'));
    }

    public function clear()
    {
        $logPath = storage_path('logs/laravel.log');
        if (File::exists($logPath)) {
            File::put($logPath, ''); // Mengosongkan log
            return back()->with('success', 'Log berhasil dibersihkan!');
        }
        return back()->with('error', 'File log tidak ditemukan.');
    }
}