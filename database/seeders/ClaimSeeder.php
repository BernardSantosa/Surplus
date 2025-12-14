<?php

namespace Database\Seeders;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $receivers = User::where('role', 'receiver')->pluck('id')->toArray();

        $foodItems = FoodItem::select('id', 'quantity')->get();

        $statuses = ['pending', 'approved', 'rejected', 'completed', 'cancelled'];

        foreach ($foodItems as $food) {

            if ($food->quantity <= 0) {
                continue;
            }

            if (rand(1, 100) > 60) {
                continue;
            }
            $claimQty = rand(1, min($food->quantity, 3));
            $status = $faker->randomElement($statuses);
            $verificationCode = null;

            if (in_array($status, ['approved', 'completed'])) {
                $verificationCode = strtoupper(Str::random(4)); 
            }
            
            DB::table('claims')->insert([
                'food_id' => $food->id,
                'receiver_id' => $faker->randomElement($receivers),
                'quantity' => $claimQty,
                'status' => $status,
                'verification_code' => $verificationCode,
                'message' => $faker->boolean(60) ? $faker->sentence(6) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
