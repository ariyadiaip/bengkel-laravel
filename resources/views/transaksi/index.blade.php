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
                            <a href="{{ route('transaksi.edit', $t->id_transaksi) }}" class="btn btn-warning btn-sm flex-item">
                                <i class="bi bi-pencil-square"></i> &nbsp;Edit
                            </a>
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
                document.querySelectorAll('[data-bs-toggle="modal"]').forEach(button => {
                    button.addEventListener('click', function () {
                        document.getElementById('delete-form').setAttribute('action', this.getAttribute('data-action'));
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
