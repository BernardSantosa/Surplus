<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Claim;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DonorController extends Controller
{
    public function index()
    {
        // $userId = Auth::id();
        $userId = 1;
        $user = User::find($userId);
        $totalDonated = FoodItem::where('user_id', $userId)->count();
        $activeItems = FoodItem::where('user_id', $userId)->where('status', 'available')->count();
        $totalClaims = Claim::whereHas('fooditems', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();
        $foodItems = FoodItem::where('user_id', $userId)->latest()->get();

        return view('donor.dashboard', compact('user', 'totalDonated', 'activeItems', 'totalClaims', 'foodItems'));
    }

    public function create()
    {
        $userId = 1;
        $user = User::find($userId);
        $categories = Category::all();
        return view('donor.food.create', compact('user', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'pickup_location' => 'required|string',
            'expires_at' => 'required|date|after:today',
            'photo' => 'nullable|image|max:2048', 
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Simpan ke folder 'storage/app/public/foodImages'
            $photoPath = $request->file('photo')->store('foodImages', 'public');
        }

        FoodItem::create([
            'user_id' => 1, # Auth::id()
            'category_id' => $validated['category_id'],
            'name' => $validated['name'],
            'description' => $validated['description'],
            'quantity' => $validated['quantity'],
            'pickup_location' => $validated['pickup_location'],
            'expires_at' => $validated['expires_at'],
            'photo' => $photoPath,
            'status' => 'available',
        ]);

        return redirect()->route('donor.dashboard')->with('success', 'Makanan berhasil didonasikan!');
    }

    public function edit(FoodItem $foodItem)
    {
        if ($foodItem->user_id !== 1) { # Auth::id()
            abort(403);
        }

        $categories = Category::all();
        return view('donor.food.edit', compact('foodItem', 'categories'));
    }

    public function update(Request $request, FoodItem $foodItem)
    {
        if ($foodItem->user_id !== 1) abort(403); # Auth::id()

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'quantity' => 'required|integer',
            'description' => 'nullable',
            'pickup_location' => 'required',
            'expires_at' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            if ($foodItem->photo) {
                Storage::disk('public')->delete($foodItem->photo);
            }

            $validated['photo'] = $request->file('photo')->store('foodImages', 'public');
        }

        $foodItem->update($validated);

        return redirect()->route('donor.dashboard')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(FoodItem $foodItem)
    {
        if ($foodItem->user_id !== 1) abort(403); # Auth::id()

        if ($foodItem->photo) {
            Storage::disk('public')->delete($foodItem->photo);
        }

        $foodItem->delete();

        return redirect()->route('donor.dashboard')->with('success', 'Item berhasil dihapus.');
    }

    public function requests()
    {
        $claims = Claim::whereHas('fooditems', function($query) {
            $query->where('user_id', 1); # Auth::id()
        })->where('status', 'pending') 
        ->with(['fooditems', 'receiver']) 
        ->latest()
        ->get();

        return view('donor.requests.index', compact('claims'));
    }

    public function approve(Claim $claim)
    {
        if ($claim->fooditems->user_id !== 1) abort(403); # Auth::id()

        $claim->update(['status' => 'approved']);

        // Opsional: Update status makanan jadi 'claimed' agar tidak bisa diklaim orang lain
        $claim->fooditems->update(['status' => 'claimed']);

        return back()->with('success', 'Permintaan berhasil disetujui. Silakan hubungi penerima.');
    }

    public function reject(Claim $claim)
    {
        if ($claim->fooditems->user_id !== 1) abort(403); # Auth::id()

        $claim->update(['status' => 'rejected']);

        return back()->with('success', 'Permintaan ditolak.');
    }
}
