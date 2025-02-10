@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Transaksi</h2>

    <!-- Pencarian & Sorting -->
    <form action="{{ route('transaksi.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari transaksi..." autocomplete="off" value="{{ request('search') }}">
            <select name="sort" class="form-select" style="max-width: 200px;">
                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Tombol Tambah -->
    <a href="{{ route('transaksi.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Transaksi
    </a>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Transaksi -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>No Kuitansi</th>
                        <th>Tanggal Transaksi</th>
                        <th>Total Bayar</th>
                        <th>Status Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($transaksi as $index => $t)
                    <tr>
                        <td class="text-center">{{ $transaksi->firstItem() + $index }}</td>
                        <td>{{ $t->no_kuitansi }}</td>
                        <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->locale('id')->translatedFormat('d F Y') }}</td>
                        <td>Rp {{ number_format($t->grand_total, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $t->status_pembayaran == 'Lunas' ? 'bg-success' : 'bg-warning' }}">
                                {{ $t->status_pembayaran }}
                            </span>
                        </td>
                        <td class="actions">
                            <a href="{{ route('transaksi.show', $t->id_transaksi) }}" class="btn btn-info btn-sm flex-item">
                                <i class="bi bi-eye"></i> &nbsp;Detail
                            </a>
                            <button type="button" class="btn btn-warning btn-sm flex-item" data-bs-toggle="modal" data-bs-target="#editModal" data-action="{{ route('transaksi.updateStatusOnIndex', $t->id_transaksi) }}" data-kuitansi="{{ $t->no_kuitansi }}" data-status="{{ $t->status_pembayaran }}">
                                <i class="bi bi-pencil-square"></i> &nbsp;Edit
                            </button>
                            <button type="button" class="btn btn-danger btn-sm flex-item" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('transaksi.destroy', $t->id_transaksi) }}">
                                <i class="bi bi-trash"></i> &nbsp;Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- Modal Edit Status -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Edit Status Pembayaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="edit-status-form" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <p><strong>No. Kuitansi:</strong> <span id="edit-no-kuitansi"></span></p>
                                <div class="mb-3">
                                    <label for="status_pembayaran" class="form-label">Status Pembayaran:</label>
                                    <select class="form-control" name="status_pembayaran" id="status_pembayaran">
                                        <option value="Lunas">Lunas</option>
                                        <option value="Belum Lunas">Belum Lunas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Penghapusan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Apakah Anda yakin ingin menghapus data ini?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <form id="delete-form" action="" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    // Modal Edit Status
                    document.querySelectorAll("[data-bs-target='#editModal']").forEach(button => {
                        button.addEventListener("click", function () {
                            const actionUrl = this.getAttribute("data-action");
                            const noKuitansi = this.getAttribute("data-kuitansi"); // Ambil no kuitansi dari tombol
                            const statusPembayaran = this.getAttribute("data-status"); // Ambil status pembayaran saat ini

                            document.getElementById("edit-status-form").setAttribute("action", actionUrl);
                            document.getElementById("edit-no-kuitansi").textContent = noKuitansi; // Masukkan ke modal

                            // Atur opsi yang terpilih di dropdown
                            document.getElementById("status_pembayaran").value = statusPembayaran;
                        });
                    });

                    // Modal Hapus
                    document.querySelectorAll("[data-bs-target='#deleteModal']").forEach(button => {
                        button.addEventListener("click", function () {
                            const actionUrl = this.getAttribute("data-action");
                            document.getElementById("delete-form").setAttribute("action", actionUrl);
                        });
                    });
                });
            </script>
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        <nav>
            <div class="d-flex justify-content-center">
                {{ $transaksi->appends(['search' => request()->search, 'sort' => request()->sort])->links() }}
            </div>
        </nav>
    </div>
</div>
@endsection
