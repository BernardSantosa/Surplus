@extends('layouts.receiver')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-9">
            
            {{-- Breadcrumb Back Button --}}
            <div class="mb-3">
                <a href="{{ route('receiver.history') }}" class="text-decoration-none text-muted small hover-success">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>

            <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                {{-- Hero Image --}}
                <div class="position-relative bg-light">
                    {{-- Logic Gambar: Ambil dari relasi fooditems milik claim --}}
                    @if($claim->fooditems && $claim->fooditems->photo)
                        <img src="{{ asset($claim->fooditems->photo) }}" 
                             class="w-100" 
                             style="height: 400px; object-fit: cover;" 
                             alt="{{ $claim->fooditems->name }}"
                             onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=No+Image';">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted" style="height: 300px;">
                            <div class="text-center">
                                <i class="bi bi-camera-video-off fs-1 opacity-25"></i>
                                <p class="small mt-2">Tidak ada foto tersedia</p>
                            </div>
                        </div>
                    @endif

                    {{-- Overlay Judul --}}
                    <div class="position-absolute bottom-0 start-0 w-100 p-3 bg-gradient-dark text-white" 
                         style="background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);">
                        <h2 class="fw-bold mb-0 text-white text-shadow">{{ $claim->fooditems->name ?? 'Item Dihapus' }}</h2>
                        <div class="d-flex align-items-center gap-2 mt-1">
                            <span class="badge bg-success shadow-sm">{{ $claim->fooditems->category->name ?? 'Umum' }}</span>
                            <small><i class="bi bi-person-fill"></i> {{ $claim->fooditems->users->name ?? 'Donatur' }}</small>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-4 p-md-5">
                    
                    {{-- Info Cards Grid --}}
                    <div class="row g-3 mb-4">
                        {{-- 1. JUMLAH REQUEST (Bukan Stok Makanan) --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-success fw-bold text-uppercase" style="font-size: 0.7rem;">Jumlah Request</small>
                                <div class="fs-5 fw-bold text-dark">{{ $claim->quantity }} <span class="fs-6 text-muted fw-normal">Porsi</span></div>
                            </div>
                        </div>

                        {{-- 2. TANGGAL REQUEST --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-secondary fw-bold text-uppercase" style="font-size: 0.7rem;">Tanggal Request</small>
                                <div class="fs-5 fw-bold text-dark">{{ $claim->created_at->format('d M') }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $claim->created_at->format('H:i') }} WIB</small>
                            </div>
                        </div>

                        {{-- 3. WAKTU PICKUP --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-warning fw-bold text-uppercase" style="font-size: 0.7rem;">Waktu Pickup</small>
                                <div class="fw-bold text-dark"><i class="bi bi-clock me-1"></i>{{ $claim->fooditems->pickup_time ?? '-' }}</div>
                            </div>
                        </div>

                        {{-- 4. LOKASI --}}
                        <div class="col-6 col-md-3">
                            <div class="p-3 bg-light rounded-3 h-100 border border-light">
                                <small class="text-primary fw-bold text-uppercase" style="font-size: 0.7rem;">Lokasi</small>
                                <div class="fw-bold text-dark small text-truncate"><i class="bi bi-geo-alt-fill me-1"></i>{{ $claim->fooditems->pickup_location ?? '-' }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5">
                        <h5 class="fw-bold text-success mb-3">Deskripsi & Kondisi</h5>
                        <p class="text-secondary lh-lg mb-0">{{ $claim->fooditems->description ?? 'Tidak ada deskripsi detail.' }}</p>
                    </div>

                    {{-- STATUS TRANSAKSI SECTION (Pengganti Form Claim) --}}
                    <div class="card border-0 shadow-sm rounded-3 p-4 {{ $claim->status == 'cancelled' || $claim->status == 'rejected' ? 'bg-danger bg-opacity-10' : ($claim->status == 'completed' ? 'bg-success bg-opacity-10' : 'bg-warning bg-opacity-10') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold mb-0 text-dark">Status Transaksi</h6>
                            
                            {{-- LOGIC BADGE STATUS --}}
                            @if($claim->status == 'pending')
                                <span class="badge bg-warning text-dark border border-warning px-3 py-2">Pending / Menunggu</span>
                            @elseif($claim->status == 'approved')
                                <span class="badge bg-success px-3 py-2">Disetujui & Siap Ambil</span>
                            @elseif($claim->status == 'completed')
                                <span class="badge bg-primary px-3 py-2">Selesai</span>
                            @elseif($claim->status == 'cancelled')
                                <span class="badge bg-secondary px-3 py-2">Dibatalkan</span>
                            @else
                                <span class="badge bg-danger px-3 py-2">Ditolak</span>
                            @endif
                        </div>

                        {{-- KODE VERIFIKASI (Hanya jika disetujui) --}}
                        @if($claim->status == 'approved')
                            <div class="text-center bg-white rounded-3 p-3 border border-success border-opacity-25 mt-2 shadow-sm">
                                <small class="text-muted text-uppercase d-block mb-1">Tunjukkan Kode Ini ke Donatur</small>
                                <div class="fs-1 fw-bold text-success letter-spacing-2 font-monospace">{{ $claim->verification_code }}</div>
                                <div class="small text-muted mt-1"><i class="bi bi-info-circle me-1"></i> Donatur akan memverifikasi kode ini saat pengambilan.</div>
                            </div>
                        @endif

                        {{-- ALASAN PENOLAKAN --}}
                        @if(($claim->status == 'rejected' || $claim->status == 'cancelled') && $claim->rejection_reason)
                            <div class="bg-white rounded-3 p-3 border border-danger border-opacity-25 mt-2">
                                <small class="text-danger fw-bold d-block">Alasan:</small>
                                <p class="mb-0 text-dark small">{{ $claim->rejection_reason }}</p>
                            </div>
                        @endif

                        {{-- TOMBOL BATAL --}}
                        @if(in_array($claim->status, ['pending', 'approved']))
                            <div class="mt-4 pt-3 border-top border-secondary border-opacity-10 text-end">
                                <form action="{{ route('receiver.claim.cancel', $claim->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin batalkan permintaan ini? Makanan akan kembali tersedia untuk orang lain.')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-x-circle me-1"></i> Batalkan Permintaan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection