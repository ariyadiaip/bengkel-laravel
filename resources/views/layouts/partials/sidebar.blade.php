<div class="sidebar">
    <!-- Brand Name -->
    <div class="sidebar-header text-center">
        <h3 class="text-white">Tridjaya Merdeka Motor</h3>
    </div>

    <ul class="list-group">
        <a href="{{ route('dashboard') }}" class="list-group-item {{ Request::is('dashboard') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-house-door me-2"></i> Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="list-group-item {{ Request::is('transaksi', 'transaksi/*') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-2"></i> Transaksi
        </a>
        <a href="{{ route('pelanggan.index') }}" class="list-group-item {{ Request::is('pelanggan', 'pelanggan/*') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-person me-2"></i> Data Pelanggan
        </a>
        <a href="{{ route('suku-cadang.index') }}" class="list-group-item {{ Request::is('suku-cadang', 'suku-cadang/*') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-tools me-2"></i> Data Suku Cadang
        </a>
        <a href="{{ route('jasa.index') }}" class="list-group-item {{ Request::is('jasa', 'jasa/*') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-wrench-adjustable me-2"></i> Data Jasa
        </a>
        <a href="{{ route('mekanik.index') }}" class="list-group-item {{ Request::is('mekanik', 'mekanik/*') ? 'active' : '' }} d-flex align-items-center">
            <i class="bi bi-people me-2"></i> Data Mekanik
        </a>
    </ul>
</div>
