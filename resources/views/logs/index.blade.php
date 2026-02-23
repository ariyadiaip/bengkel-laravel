@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0"><i class="bi bi-terminal"></i> Logs</h2>
            <small class="text-muted">Monitoring aktivitas sistem dan pelacakan kesalahan (Debugging)</small>
        </div>
        <form action="{{ route('logs.clear') }}" method="POST" onsubmit="return confirm('Kosongkan semua log?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash"></i> Bersihkan Log
            </button>
        </form>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('logs.index') }}" method="GET" class="row g-2">
                <div class="col-md-7">
                    <input type="text" name="search" class="form-control" placeholder="Cari teks di log..." value="{{ request('search') }}">
                </div>
                
                <div class="col-md-3">
                    <select name="level" class="form-select">
                        <option value="">-- Semua Level --</option>
                        <option value="INFO" {{ request('level') == 'INFO' ? 'selected' : '' }}>INFO</option>
                        <option value="WARNING" {{ request('level') == 'WARNING' ? 'selected' : '' }}>WARNING</option>
                        <option value="ERROR" {{ request('level') == 'ERROR' ? 'selected' : '' }}>ERROR</option>
                        <option value="DEBUG" {{ request('level') == 'DEBUG' ? 'selected' : '' }}>DEBUG</option>
                    </select>
                </div>
                
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">
                        <i class="bi bi-search"></i> Filter
                    </button>
                    <a href="{{ route('logs.index') }}" class="btn btn-secondary">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @include('layouts.partials.alerts')

    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>storage/logs/laravel.log</span>
            <span class="badge bg-primary">{{ count(explode("\n", $logContent)) }} baris ditemukan</span>
        </div>
        <div class="card-body p-0">
            <textarea class="form-control font-monospace bg-dark text-success border-0 rounded-0" 
                      rows="18" readonly style="font-size: 0.8rem; resize: none; white-space: pre;">{{ $logContent ?: 'Tidak ada log yang sesuai dengan filter.' }}</textarea>
        </div>
    </div>
</div>
@endsection