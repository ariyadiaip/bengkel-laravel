@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Jasa</h2>

    <!-- Pencarian -->
    <form action="{{ route('jasa.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari data..." autocomplete="off" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Tombol Tambah -->
    <a href="{{ route('jasa.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Jasa
    </a>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Tabel Jasa -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Kode Jasa</th>
                        <th>Nama Jasa</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jasas as $index => $jasa)
                    <tr>
                        <td class="text-center">{{ $jasas->firstItem() + $index }}</td>
                        <td>{{ $jasa->id_jasa }}</td>
                        <td>{{ $jasa->nama_jasa }}</td>
                        <td>Rp {{ number_format($jasa->harga_satuan, 0, ',', '.') }}</td>
                        <td class="actions">
                            <a href="{{ route('jasa.edit', $jasa->id_jasa) }}" class="btn btn-warning btn-sm flex-item">
                                <i class="bi bi-pencil-square"></i> &nbsp;Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm flex-item" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('jasa.destroy', $jasa->id_jasa) }}">
                                <i class="bi bi-trash"></i> &nbsp;Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data jasa.</td>
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
                            <form id="delete-form" action="" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
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
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        <nav>
            <div class="d-flex justify-content-center">
                {{ $jasas->appends(['search' => request()->search])->links() }}
            </div>
        </nav>
    </div>
</div>
@endsection
