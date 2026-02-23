@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Mekanik</h2>

    <!-- Pencarian -->
    <form action="{{ route('mekanik.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Cari data..." autocomplete="off" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cari
            </button>
        </div>
    </form>

    <!-- Tombol Tambah -->
    <a href="{{ route('mekanik.create') }}" class="btn btn-success mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Mekanik
    </a>

    <!-- Flash Message -->
    @include('layouts.partials.alerts')

    <!-- Tabel Mekanik -->
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Nama</th>
                        <th>NPWP</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($mekaniks as $index => $mekanik)
                    <tr>
                        <td class="text-center">{{ $mekaniks->firstItem() + $index }}</td> 
                        <td>{{ $mekanik->nama_mekanik }}</td>
                        <td>{{ $mekanik->npwp ?? '-' }}</td>
                        <td>{{ $mekanik->no_telepon }}</td>
                        <td class="actions">
                            <a href="{{ route('mekanik.edit', $mekanik->id_mekanik) }}" class="btn btn-warning btn-sm flex-item">
                                <i class="bi bi-pencil-square"></i> &nbsp;Edit
                            </a>
                            <button type="button" class="btn btn-danger btn-sm flex-item" data-bs-toggle="modal" data-bs-target="#deleteModal" data-action="{{ route('mekanik.destroy', $mekanik->id_mekanik) }}">
                                <i class="bi bi-trash"></i> &nbsp;Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data mekanik.</td>
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
                <script>
                    const deleteButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
                    deleteButtons.forEach(button => {
                        button.addEventListener('click', function () {
                            const formAction = this.getAttribute('data-action');
                            document.getElementById('delete-form').setAttribute('action', formAction);
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
                {{ $mekaniks->appends(['search' => request()->search])->links() }}
            </div>
        </nav>
    </div>
</div>
@endsection
