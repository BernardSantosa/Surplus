<x-app-layout>

    <x-auth-card title="Register">

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- ERROR MESSAGE --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- SUCCESS MESSAGE --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <label class="fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control mb-3" required>

            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control mb-3" required>

            <label class="fw-semibold">Password</label>
            <input type="password" name="password" class="form-control mb-3" required>

            <label class="fw-semibold">Nomor Telepon</label>
            <input type="text" name="phone" class="form-control mb-3">

            <label class="fw-semibold">Alamat</label>
            <input type="text" name="address" class="form-control mb-3">

            <label class="fw-semibold">Role</label>
            <select name="role" class="form-select mb-3" required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="donor">Donor</option>
                <option value="receiver">Receiver</option>
            </select>

            <button class="btn btn-success w-100 mt-2">Register</button>

            <div class="text-center mt-3">
                <span class="text-muted">Have an Account?</span>
                <a href="{{ route('login') }}" class="text-success fw-semibold">
                    Login Here
                </a>
            </div>
        </form>

    </x-auth-card>

</x-app-layout>