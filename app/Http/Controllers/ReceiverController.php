<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Category;
use App\Models\Claim;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReceiverController extends Controller
{ 
    public function index(Request $request)
    {
        $query = FoodItem::with(['user', 'category']) 
                 ->where('status', 'available'); 

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('location')) {
            $query->where('pickup_location', 'like', '%' . $request->location . '%');
        }

        $foods = $query->latest()->paginate(9);

        $categories = Category::all();

        return view('receiver.dashboard', compact('foods', 'categories'));
    }

    public function show(FoodItem $foodItem)
    {
        if ($foodItem->status !== 'available') {
            abort(404, 'Maaf, makanan ini sudah tidak tersedia.');
        }

        $foodItem->load('user');

        return view('receiver.food.show', compact('foodItem'));
    }

    public function profile()
    {
        // Hardcoded User for dev (just like your DonorController)
        // $userId = Auth::id();
        $userId = 2; // Assuming ID 2 is a receiver for testing
        
        $user = User::find($userId);

        // Stats
        $totalClaims = Claim::where('user_id', $userId)->count();
        $pendingClaims = Claim::where('user_id', $userId)->where('status', 'pending')->count();
        $approvedClaims = Claim::where('user_id', $userId)->where('status', 'approved')->count();

        // History Data (Get claims with Food details)
        // Note: 'fooditems' must match the relationship name in your Claim model
        $claimsHistory = Claim::with('fooditems') 
                         ->where('user_id', $userId)
                         ->latest()
                         ->get();

        return view('receiver.profile', compact('user', 'totalClaims', 'pendingClaims', 'approvedClaims', 'claimsHistory'));
    }
}