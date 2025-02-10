@extends('layouts.app')

@section('content')
    <h2>Detail Pelanggan</h2>
    <br>

    <!-- Informasi Pelanggan -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Informasi Pelanggan</h4>
            <hr>
            <div class="row">
                <div class="col-md-2"><strong>Nama</strong></div>
                <div class="col-md-8">: {{ $pelanggan->nama_pelanggan }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-md-2"><strong>No Telepon</strong></div>
                <div class="col-md-8">: {{ $pelanggan->no_telepon }}</div>
            </div>
            <div class="row mt-1">
                <div class="col-md-2"><strong>Alamat</strong></div>
                <div class="col-md-8">: {{ $pelanggan->alamat }}</div>
            </div>
        </div>
    </div>

    <br>

    <!-- Informasi Kendaraan -->
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Informasi Kendaraan</h4>
            <hr>
            @if ($pelanggan->kendaraan->isNotEmpty())
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Polisi</th>
                            <th>Tipe</th>
                            <th>Model</th>
                            <th>Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pelanggan->kendaraan as $kendaraan)
                            <tr>
                                <td>{{ $kendaraan->no_polisi }}</td>
                                <td>{{ $kendaraan->tipe }}</td>
                                <td>{{ $kendaraan->model }}</td>
                                <td>{{ $kendaraan->tahun }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Pelanggan ini tidak memiliki kendaraan terdaftar.</p>
            @endif
        </div>
    </div>

    <br>

    <!-- Tombol Aksi -->
    <div class="d-flex justify-content-end">
        <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary me-2">Kembali</a>
        <a href="{{ route('pelanggan.edit', $pelanggan->id_pelanggan) }}" class="btn btn-primary">Edit</a>
    </div>
@endsection
