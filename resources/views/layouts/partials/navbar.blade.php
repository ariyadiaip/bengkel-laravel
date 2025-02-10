<nav class="navbar navbar-expand-lg" style="background-color: #0044d6; color: white;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        
        <div></div>

        <!-- Nama Admin dan Dropdown di Kanan -->
        <div class="d-flex align-items-center">
            <span class="navbar-text fw-bold text-white me-2">Admin</span>

            <div class="dropdown">
                <button class="btn btn-transparent text-white" type="button" id="navbarDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots-vertical"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <!-- Tombol untuk menampilkan modal logout -->
                        <a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- Modal Konfirmasi Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-danger" onclick="document.getElementById('logout-form').submit();">Logout</button>
            </div>
        </div>
    </div>
</div>

<!-- Form Logout -->
<form id="logout-form" action="{{ route('login') }}" method="GET" style="display: none;"></form>
