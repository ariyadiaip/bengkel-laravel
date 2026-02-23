@if(session('success') || session('error'))
    <div class="mt-2">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex align-items-center py-2 px-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <div class="flex-grow-1" style="font-size: 0.9rem;">{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.5rem; position: static; margin-left: 10px; padding: 0.5rem;"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center py-2 px-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div class="flex-grow-1" style="font-size: 0.9rem;">{{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.5rem; position: static; margin-left: 10px; padding: 0.5rem;"></button>
            </div>
        @endif
    </div>
@endif