<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donor = User::where('role', 'donor')->first();
        $receiver = User::where('role', 'receiver')->first();
        
        // Ambil makanan milik donor tersebut
        $food = FoodItem::where('user_id', $donor->id)->first();

        if ($food && $receiver) {
            DB::table('claims')->insert([
                'food_id' => $food->id,
                'receiver_id' => $receiver->id,
                'status' => 'pending', 
                'message' => 'Saya butuh makanan ini untuk panti asuhan.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
