@extends('layouts.donor')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm border-0 text-center p-4">
                <div class="card-body">
                    <div class="mb-3">
                        <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center text-white" style="width: 100px; height: 100px; font-size: 40px;">
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

                    <a href="{{ route('donor.profile.edit') }}" class="btn btn-outline-primary w-100">
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-primary text-white h-100">
                        <div class="card-body text-center">
                            <h3>{{ $totalDonations }}</h3>
                            <small>Total Donasi</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-success text-white h-100">
                        <div class="card-body text-center">
                            <h3>{{ $activeDonations }}</h3>
                            <small>Sedang Aktif</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm bg-info text-white h-100">
                        <div class="card-body text-center">
                            <h3>{{ $completedDonations }}</h3>
                            <small>Berhasil Disalurkan</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Aktivitas Terakhir</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Nama Makanan</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentDonations as $item)
                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $item->name }}</td>
                                        <td>{{ $item->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if($item->status == 'available')
                                                <span class="badge bg-success">Available</span>
                                            @elseif($item->status == 'claimed')
                                                <span class="badge bg-secondary">Claimed</span>
                                            @else
                                                <span class="badge bg-warning text-dark">{{ ucfirst($item->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">Belum ada aktivitas.</td>
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