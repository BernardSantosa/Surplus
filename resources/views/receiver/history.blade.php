@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-success">Riwayat Permintaan</h3>
        
        <form action="{{ route('receiver.history') }}" method="GET" class="d-flex gap-2 align-items-center">
            <label class="text-muted small">Urutkan:</label>
            <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="date" {{ request('sort') == 'date' ? 'selected' : '' }}>Tanggal Terbaru</option>
                <option value="food_name" {{ request('sort') == 'food_name' ? 'selected' : '' }}>Nama Makanan (A-Z)</option>
                <option value="status" {{ request('sort') == 'status' ? 'selected' : '' }}>Status</option>
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        {{-- 1. SORT BY NAMA MAKANAN --}}
                        <th class="ps-4">
                            <a href="{{ route('receiver.history', [
                                    'sort' => 'food_name', 
                                    'direction' => (request('sort') == 'food_name' && request('direction') == 'asc') ? 'desc' : 'asc'
                                ]) }}" 
                            class="text-dark text-decoration-none fw-bold">
                                
                                Makanan
                                
                                {{-- LOGIC IKON --}}
                                @if(request('sort') == 'food_name')
                                    @if(request('direction') == 'asc') ↑ @else ↓ @endif
                                @else
                                    <span class="text-muted small">+</span>
                                @endif
                            </a>
                        </th>

                        {{-- 2. SORT BY DONOR (Tidak disort, teks biasa) --}}
                        <th>Donor</th>

                        {{-- 3. SORT BY TANGGAL --}}
                        <th>
                            <a href="{{ route('receiver.history', [
                                    'sort' => 'date', 
                                    'direction' => (request('sort') == 'date' && request('direction') == 'desc') ? 'asc' : 'desc'
                                ]) }}" 
                            class="text-dark text-decoration-none fw-bold">
                            
                                Tanggal Request

                                @if(request('sort') == 'date' || !request('sort')) {{-- Default active --}}
                                    @if(request('direction') == 'asc') ↑ @else ↓ @endif
                                @else
                                    <span class="text-muted small">+</span>
                                @endif
                            </a>
                        </th>

                        {{-- 4. SORT BY STATUS --}}
                        <th>
                            <a href="{{ route('receiver.history', [
                                    'sort' => 'status', 
                                    'direction' => (request('sort') == 'status' && request('direction') == 'asc') ? 'desc' : 'asc'
                                ]) }}" 
                            class="text-dark text-decoration-none fw-bold">
                            
                                Status

                                @if(request('sort') == 'status')
                                    @if(request('direction') == 'asc') ↑ @else ↓ @endif
                                @else
                                    <span class="text-muted small">+</span>
                                @endif
                            </a>
                        </th>

                        <th class="text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($claimsHistory as $claim)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                @if($claim->fooditems && $claim->fooditems->photo)
                                    <img src="{{ asset($claim->fooditems->photo) }}" 
                                         class="rounded object-fit-cover" width="50" height="50">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" 
                                         style="width:50px; height:50px;">🍽️</div>
                                @endif
                                <div>
                                    <div class="fw-bold">{{ $claim->fooditems->name ?? 'Item Dihapus' }}</div>
                                    <small class="text-muted">{{ $claim->fooditems->quantity ?? '-' }} Porsi</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            {{ $claim->fooditems->users->name ?? 'Unknown' }}
                        </td>
                        <td>
                            {{ $claim->created_at->format('d M Y') }}<br>
                            <small class="text-muted">{{ $claim->created_at->format('H:i') }}</small>
                        </td>
                        <td>
                            @if($claim->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif($claim->status == 'approved' || $claim->status == 'claimed')
                                <span class="badge bg-success">Berhasil</span>
                            @elseif($claim->status == 'cancelled')
                                <span class="badge bg-secondary">Dibatalkan</span>
                            @else
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                @if($claim->fooditems)
                                    <a href="{{ route('receiver.food.show', $claim->food_id) }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        Detail
                                    </a>
                                @endif

                                @if(in_array($claim->status, ['pending', 'claimed']))
                                    <form action="{{ route('receiver.claim.cancel', $claim->id) }}" method="POST" 
                                          onsubmit="return confirm('Yakin batalkan permintaan ini? Makanan akan kembali tersedia untuk orang lain.')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Batal
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            Belum ada riwayat permintaan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-center mt-3">
            {{ $claimsHistory->links() }}
        </div>
    </div>
</div>
@endsection