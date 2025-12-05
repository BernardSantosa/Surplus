@extends('layouts.receiver')

@section('content')
<div class="container py-4">

    <div class="row">
        <!-- User Information Card -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="rounded-circle bg-warning d-inline-flex align-items-center justify-content-center text-white" style="width: 100px; height: 100px; font-size: 40px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <h4 class="card-title fw-bold mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="text-start">
                        <small class="text-muted">Bergabung sejak:</small>
                        <p class="fw-bold">{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}</p>
                    </div>

                    <div class="text-start border-top pt-3">
                        <div class="mb-2">
                            <small class="text-muted d-block">No. Telepon</small>
                            <span class="fw-medium">{{ $user->phone ?? '-' }}</span>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Alamat</small>
                            <span class="fw-medium">{{ $user->address ?? '-' }}</span>
                        </div>
                    </div>

                    <a href="{{ route('receiver.profile-edit') }}" class="btn btn-outline-warning w-100">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics & History -->
        <div class="col-md-8">
            <!-- Stats Row -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body text-center">
                            <h3>{{ $totalClaims }}</h3>
                            <small>Total Permintaan</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-warning text-dark h-100">
                        <div class="card-body text-center">
                            <h3>{{ $pendingClaims }}</h3>
                            <small>Menunggu Persetujuan</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body text-center">
                            <h3>{{ $approvedClaims }}</h3>
                            <small>Disetujui</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- History Table -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Riwayat Permintaan Makanan</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Makanan yg Diminta</th>
                                    <th>Tanggal Request</th>
                                    <th>Status Klaim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($claimsHistory as $claim)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-medium">{{ $claim->fooditems->name ?? 'Item dihapus' }}</div>
                                            <small class="text-muted">Dari: {{ $claim->fooditems->user->name ?? 'Unknown' }}</small>
                                        </td>
                                        <td>{{ $claim->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($claim->status == 'pending')
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @elseif($claim->status == 'approved')
                                                <span class="badge bg-success">Disetujui</span>
                                            @elseif($claim->status == 'rejected')
                                                <span class="badge bg-danger">Ditolak</span>
                                            @else
                                                <span class="badge bg-secondary">Selesai</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada riwayat permintaan.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection