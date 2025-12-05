<x-guest-layout>

    <div class="container py-5">

        <div class="text-center mb-5">
            <h1 class="fw-bold text-success">Welcome to Surplus</h1>
            <p class="lead text-muted">
                Platform penyelamatan makanan yang menghubungkan Donor dan Receiver 
                untuk mengurangi food waste dan mendukung SDG 12.
            </p>
        </div>

        <div class="row g-4">

            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-success">Mengapa Surplus?</h4>
                    <p class="text-muted mt-2">
                        Surplus membantu bisnis makanan dan individu untuk menyalurkan 
                        makanan berlebih kepada pihak yang membutuhkan.
                    </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm p-4 h-100">
                    <h4 class="fw-bold text-success">Bergabung Sekarang</h4>
                    <p class="text-muted mt-2">
                        Daftar sebagai <strong>Donor</strong> atau <strong>Receiver</strong> 
                        dan mulai berkontribusi dalam mengurangi pemborosan makanan.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-success w-50 mt-3">
                        Register
                    </a>
                </div>
            </div>

        </div>

    </div>

</x-guest-layout>
