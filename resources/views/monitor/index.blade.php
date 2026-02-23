@extends('layouts.app')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-speedometer2 text-primary"></i> Resource Monitor</h2>
            <small class="text-muted">Monitoring Environment & Database Statistics</small>
        </div>
        <div class="badge bg-success py-2 px-3 shadow-sm">
            <i class="bi bi-lightning-fill"></i> Response: {{ $responseMs }} ms
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white">
                    <i class="bi bi-cpu me-2"></i> Environment Metrics
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover mb-0" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr><th>Parameter</th><th>Value</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            <tr><td>PHP Version</td><td>{{ $metrics['php_version'] }}</td><td><span class="badge bg-info">Stable</span></td></tr>
                            <tr><td>Laravel Version</td><td>{{ $metrics['laravel_version'] }}</td><td><span class="badge bg-info">LTS</span></td></tr>
                            <tr><td>Memory Used</td><td>{{ $metrics['memory_used'] }} MB</td><td><span class="badge bg-success">Healthy</span></td></tr>
                            <tr><td>Memory Peak</td><td>{{ $metrics['memory_peak'] }} MB</td><td><span class="badge bg-warning text-dark">Monitor</span></td></tr>
                            <tr><td>Database Size</td><td>{{ $dbSize }} KB</td><td><span class="badge bg-danger">MySQL</span></td></tr>
                            <tr><td>Storage Used</td><td>{{ $storageSize }} KB</td><td><span class="badge bg-secondary">Files</span></td></tr>
                            <tr><td>Memory Limit</td><td>{{ $metrics['memory_limit'] }}</td><td><span class="badge bg-secondary">Config</span></td></tr>
                            <tr><td>Max Exec Time</td><td>{{ $metrics['max_exec_time'] }}</td><td><span class="badge bg-secondary">System</span></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-database-fill me-2"></i> Database Record Count
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($dbStats as $label => $count)
                        <div class="col-6">
                            <div class="p-3 border rounded bg-light text-center h-100 shadow-sm">
                                <small class="text-uppercase text-muted d-block" style="font-size: 0.65rem; letter-spacing: 1px;">
                                    <i class="bi bi-{{ $label == 'users' ? 'people' : ($label == 'transaksi' ? 'file-earmark-text' : 'record-circle') }} me-1"></i>
                                    {{ str_replace('_', ' ', $label) }}
                                </small>
                                <h4 class="mb-0 fw-bold mt-1">{{ $count }}</h4>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer bg-white text-muted small border-top-0 pt-0">
                    <hr class="mt-0">
                    <i class="bi bi-info-circle me-1"></i> Data diambil secara real-time dari MySQL.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection