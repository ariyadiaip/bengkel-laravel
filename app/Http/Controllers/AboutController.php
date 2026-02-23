<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutController extends Controller
{
    public function index()
    {

        // Mengambil versi MariaDB/MySQL secara real-time
        $dbVersion = DB::select("SELECT VERSION() as version")[0]->version;

        $techStack = [
            'Framework' => ['name' => 'Laravel', 'version' => app()->version(), 'icon' => 'bi-bootstrap-fill'],
            'Language'  => ['name' => 'PHP', 'version' => PHP_VERSION, 'icon' => 'bi-code-slash'],
            'Database'  => ['name' => 'MySQL (MariaDB Driver)', 'version' => $dbVersion, 'icon' => 'bi-database'],
            'Web Server'  => ['name' => 'Apache', 'version' => '2.4.58', 'icon' => 'bi-server'],
            'Version Control' => ['name' => 'Git', 'version' => '2.43.0', 'icon' => 'bi-git'],
            'Frontend'  => ['name' => 'Bootstrap', 'version' => '5.3.0', 'icon' => 'bi-lightning-fill'],
            'Icons'     => ['name' => 'Bootstrap Icons', 'version' => '1.13.1', 'icon' => 'bi-info-circle'],
            'Environment' => ['name' => 'XAMPP', 'version' => '8.2.12', 'icon' => 'bi-pc-display'],
        ];

        $developer = [
            'nama'   => 'Aip Ariyadi',
            'nim'    => '10122901',
            'kampus' => 'Universitas Komputer Indonesia',
            'proyek' => 'Sistem Informasi Manajemen Bengkel (Tridjaya Merdeka Motor)'
        ];

        return view('about.index', compact('techStack', 'developer'));
    }
}