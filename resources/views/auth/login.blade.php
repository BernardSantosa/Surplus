<x-app-layout>

    <x-auth-card title="Login">

        {{-- ERROR MESSAGE --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control mb-3"
                   placeholder="you@example.com" required>

            <label class="fw-semibold">Password</label>
            <input type="password" name="password" class="form-control mb-3"
                   placeholder="••••••••" required>

            <button class="btn btn-success w-100 mt-2">Login</button>

            <div class="text-center mt-3">
                <a href="{{ route('password.request') }}" class="text-muted">
                    Forgot your password?
                </a>
            </div>

            <div class="text-center mt-3">
                <span class="text-muted">No Account?</span>
                <a href="{{ route('register') }}" class="text-success fw-semibold">
                    Register Here
                </a>
            </div>

        </form>

    </x-auth-card>

</x-app-layout>