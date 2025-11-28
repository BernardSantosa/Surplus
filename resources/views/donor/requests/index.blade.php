@extends('layouts.donor')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-warning text-dark">
        <h5 class="mb-0">Permintaan Masuk (Pending)</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Penerima</th>
                        <th>Makanan Diminta</th>
                        <th>Pesan</th>
                        <th>Tanggal Request</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claims as $claim)
                    <tr>
                        <td>
                            <strong>{{ $claim->receiver->name }}</strong><br>
                            <small class="text-muted">{{ $claim->receiver->phone }}</small>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($claim->fooditems->photo)
                                    <img src="{{ asset('storage/' . $claim->fooditems->photo) }}" width="40" class="rounded me-2">
                                @endif
                                <span>{{ $claim->fooditems->name }}</span>
                            </div>
                        </td>
                        <td>{{ $claim->message ?? '-' }}</td>
                        <td>{{ $claim->created_at->diffForHumans() }}</td>
                        <td>
                            <form action="{{ route('donor.requests.approve', $claim->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-success">✓ Terima</button>
                            </form>
                            <form action="{{ route('donor.requests.reject', $claim->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Tolak permintaan ini?')">✗ Tolak</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada permintaan baru.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection