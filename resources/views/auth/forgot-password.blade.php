<x-app-layout>

    <x-auth-card title="Reset Password">

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <label class="fw-semibold">Email</label>
            <input type="email" name="email" class="form-control mb-3" required>

            <button class="btn btn-success w-100">Send Reset Link</button>
        </form>

    </x-auth-card>

</x-app-layout>