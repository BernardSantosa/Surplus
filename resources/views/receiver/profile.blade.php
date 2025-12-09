@extends('layouts.receiver')

@section('content')
<div class="container py-4">

    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-success text-white shadow-sm border-0">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-4">
                        <div class="bg-white text-success rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" 
                             style="width: 80px; height: 80px; font-size: 32px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h2 class="fw-bold mb-0">{{ $user->name }}</h2>
                            <p class="mb-0 opacity-75">{{ $user->email }}</p>
                            <small class="opacity-75">Bergabung sejak: {{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}</small>
                        </div>
                    </div>
                    <div>
                        <a href="{{ route('receiver.profile-edit') }}" class="btn btn-light text-success fw-bold">
                            <i class="bi bi-pencil"></i> Edit Profil
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white fw-bold py-3">Informasi Kontak</div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted d-block">No. Telepon</small>
                        <span class="fw-medium fs-5">{{ $user->phone ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted d-block">Alamat</small>
                        <span class="fw-medium">{{ $user->address ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mb-4">
            <div class="row g-3 h-100">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h1 class="fw-bold mb-0">{{ $totalClaims }}</h1>
                            <small>Total Request</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h1 class="fw-bold mb-0">{{ $pendingClaims }}</h1>
                            <small>Menunggu</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body text-center d-flex flex-column justify-content-center">
                            <h1 class="fw-bold mb-0">{{ $approvedClaims }}</h1>
                            <small>Berhasil/Selesai</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-12 mt-3">
                    <a href="{{ route('receiver.history') }}" class="btn btn-outline-success w-100 py-3 border-2 border-dashed">
                        Lihat Riwayat Lengkap Makanan &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection