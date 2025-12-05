<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function about()
    {
        return view('about');
    }

    public function how()
    {
        return view('how');
    }
}
