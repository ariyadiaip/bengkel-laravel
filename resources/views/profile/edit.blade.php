@extends('layouts.app') {{-- Sesuaikan dengan layout kamu --}}

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">Pengaturan Profil</div>
                <div class="card-body text-center">
                    
                    <!-- Flash Message -->
                    @include('layouts.partials.alerts')

                    <img src="{{ asset('images/users/' . Auth::user()->photo) }}" 
                         class="rounded-circle mb-3 border" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                    
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
                        </div>

                        <div class="mb-4 text-start">
                            <label class="form-label fw-bold">Ganti Foto Profil</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Maks: 2MB</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection