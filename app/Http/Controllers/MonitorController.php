<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Mekanik;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use App\Models\SukuCadang;
use App\Models\Jasa;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MonitorController extends Controller
{
    public function index(): View
    {
        $startTime = microtime(true);

        // Metrik Sistem
        $metrics = [
            'php_version'     => PHP_VERSION,
            'laravel_version' => app()->version(),
            'memory_used'     => round(memory_get_usage(true) / 1024 / 1024, 2), // MB
            'memory_peak'     => round(memory_get_peak_usage(true) / 1024 / 1024, 2), // MB
            'memory_limit'    => ini_get('memory_limit'),
            'max_exec_time'   => ini_get('max_execution_time') . 's',
            'upload_max'      => ini_get('upload_max_filesize'),
        ];

        $dbName = config('database.connections.mysql.database');
        $dbSizeData = DB::select("SELECT SUM(data_length + index_length) / 1024 AS size 
                                 FROM information_schema.TABLES 
                                 WHERE table_schema = ?", [$dbName]);
        $dbSize = round($dbSizeData[0]->size ?? 0, 2); // Dalam KB

        // 3. Hitung Ukuran Storage (Folder Images/Users)
        $storagePath = public_path('images/users');
        $storageSize = 0;
        if (File::exists($storagePath)) {
            foreach (File::allFiles($storagePath) as $file) {
                $storageSize += $file->getSize();
            }
        }
        $storageSize = round($storageSize / 1024, 2); // Dalam KB

        // Statistik Database - Memantau Resource Data
        $dbStats = [
            'users'        => User::count(),
            'mekanik'      => Mekanik::count(),
            'pelanggan'    => Pelanggan::count(),
            'transaksi'    => Transaksi::count(),
            'suku_cadang'  => SukuCadang::count(),
            'jasa'         => Jasa::count(),
        ];

        // Hitung waktu respon dalam ms
        $responseMs = round((microtime(true) - $startTime) * 1000, 2);

        return view('monitor.index', compact('metrics', 'dbStats', 'responseMs', 'dbSize', 'storageSize'));
    }
}