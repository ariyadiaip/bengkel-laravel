@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="mb-4">
        <h2><i class="bi bi-info-circle text-primary"></i> About</h2>
        <small class="text-muted">Dokumentasi & Spesifikasi Perangkat Lunak</small>
    </div>

    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0 fw-bold">Analisis Tools (Tech Stack)</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-4">Daftar teknologi dan versi yang digunakan dalam pengembangan sistem ini sebagai pemenuhan standar kompetensi pemrograman.</p>
                    
                    <div class="row g-4">
                        @foreach($techStack as $category => $detail)
                        <div class="col-md-6">
                            <div class="d-flex align-items-center p-3 border rounded bg-light">
                                <div class="flex-shrink-0 bg-white shadow-sm rounded p-2 text-primary">
                                    <i class="bi {{ $detail['icon'] }} fs-3"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <small class="text-uppercase text-muted d-block" style="font-size: 0.7rem; font-weight: 700;">{{ $category }}</small>
                                    <h6 class="mb-0 fw-bold">{{ $detail['name'] }}</h6>
                                    <span class="badge bg-secondary" style="font-size: 0.7rem;">v{{ $detail['version'] }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 bg-primary text-white overflow-hidden">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-person-badge fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $developer['nama'] }}</h4>
                    <p class="mb-0 opacity-75">{{ $developer['nim'] }}</p>
                    <hr class="border-white opacity-25 my-4">
                    <h6 class="fw-bold mb-1">{{ $developer['kampus'] }}</h6>
                    <small class="opacity-75">{{ $developer['proyek'] }}</small>
                </div>
                <div class="card-footer bg-white text-primary text-center py-3 border-0">
                    <small class="fw-bold text-uppercase">Uji Kompetensi</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection