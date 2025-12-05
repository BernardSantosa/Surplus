<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    protected $creator;

    public function __construct(CreatesNewUsers $creator)
    {
        $this->creator = $creator;
    }

    // Show register page
    public function show()
    {
        return view('auth.register');
    }

    // Handle register request
    public function register(Request $request)
    {
        // Create user using Jetstream/Fortify logic
        $user = $this->creator->create($request->all());

        event(new Registered($user));

        // JETSTREAM DEFAULT: auto login → kita matikan
        Auth::logout();

        return redirect()
            ->route('login')
            ->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}
