<div class="offcanvas-body">

    <a href="{{ route('home') }}" class="nav-link">Home</a>
    <a href="{{ route('about') }}" class="nav-link">About</a>
    <a href="{{ route('how') }}" class="nav-link">How it Works</a>

    @guest
        <a href="{{ route('login') }}" class="btn btn-outline-success w-100 mt-3">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success w-100 mt-2">Register</a>
    @endguest

    @auth
        <a href="{{ route('dashboard') }}" class="nav-link mt-3">Dashboard</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-danger w-100 mt-3">Logout</button>
        </form>
    @endauth

</div>