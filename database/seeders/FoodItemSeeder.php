<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Category;
use Faker\Factory as Faker;

class FoodItemSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $users = User::where('role', 'donor')->pluck('id')->toArray();
        $categoryMap = Category::pluck('id', 'name')->toArray();

        $manualDescriptions = [
            "Roti gandum utuh premium, kemasan masih tersegel rapi dan higienis. Merupakan sisa stok toko hari ini (unsold), expired date dijamin masih aman. Sangat cocok untuk sarapan sehat atau dibuat sandwich.",
            "Croissant butter flaky khas Perancis, sisa display bakery pagi yang belum tersentuh pelanggan. Tekstur luarnya masih renyah dengan aroma butter yang wangi. Nikmat disantap hangat dengan kopi.",
            "Muffin coklat dengan tekstur moist dan lembut, kondisi sangat baik karena merupakan kelebihan pesanan snack box rapat tadi siang. Rasa coklatnya pekat, pas untuk teman minum teh sore.",
            "Nasi goreng spesial kaya bumbu rempah, porsi mengenyangkan lengkap dengan irisan telur dadar tebal. Kondisi higienis, merupakan sisa catering makan siang yang belum dibuka. Tinggal hangatkan sebentar, siap santap.",
            "Nasi kuning box komplit, disajikan dengan orek tempe manis gurih dan perkedel kentang lembut. Sisa acara syukuran, dikemas rapi dan bersih. Solusi makan praktis dan nikmat tanpa perlu masak.",
            "Chicken Teriyaki Rice Bowl, potongan ayam masih juicy dengan bumbu meresap sempurna. Saus teriyaki dikemas terpisah agar nasi tidak lembek. Kondisi fresh dan siap makan.",
            "Beef Rendang daging sapi pilihan, dimasak perlahan selama 8 jam hingga bumbu meresap ke serat daging. Sisa stok rumah makan Padang, rasa otentik dan daging sangat empuk. Bisa disimpan di kulkas untuk stok lauk.",
            "Dada ayam bakar bumbu rujak, diolah rendah lemak dan tinggi protein, sangat cocok untuk menu diet sehat. Merupakan sisa meal prep harian yang masih fresh. Cukup panaskan di microwave/teflon.",
            "Fish Fillet ikan dori berbalut tepung roti yang gurih, tekstur masih garing dan daging ikan lembut. Sisa stok restoran seafood, kualitas premium. Enak dimakan dengan saus tartar atau sambal.",
            "Satu paket apel fuji segar pilihan. Terdapat sedikit memar alami di kulit (imperpect), namun daging buah masih sangat renyah, manis, dan bagus. Sangat layak konsumsi atau cocok dibuat jus sehat.",
            "Pisang cavendish satu sisir utuh, tingkat kematangan pas dan warna kuning cerah. Tekstur daging buah lembut dan manis, cocok untuk langsung dimakan sebagai sumber energi instan atau bahan smoothie.",
            "Salad buah segar potongan besar dengan dressing mayo keju yang melimpah. Sisa stok toko buah potong hari ini, vitamin terjaga. Segera simpan di kulkas dan nikmati dalam kondisi dingin.",
            "Bowl salad sayur mix (selada, tomat cherry, timun jepang) yang renyah. Dilengkapi dressing wijen sangrai gurih. Sayuran masih segar dan 'kriuk', sisa stok display yang belum tersentuh.",
            "Selada keriting hidroponik bebas pestisida, masih utuh dengan akarnya untuk menjaga kesegaran lebih lama. Sisa panen kebun rumahan, jauh lebih fresh dibanding beli di pasar. Cocok untuk lalapan.",
            "Tumis sayuran capcay dengan isian lengkap (wortel, kembang kol, sawi), baru dimasak sore ini. Merupakan kelebihan porsi makan malam keluarga, rasa rumahan yang lezat dan sehat.",
            "Yogurt cup rasa strawberry yang creamy. Segel tutup masih utuh sempurna. Mendekati tanggal best before namun rasa dan kualitas dijamin masih sangat aman dan enak dikonsumsi. Sumber probiotik hemat.",
            "Keju cheddar slice kemasan ekonomis, bungkus utuh isi 5 lembar. Sisa bahan kue yang tidak terpakai. Cocok untuk isian roti tawar atau topping mie instan agar lebih creamy.",
            "Susu UHT 1 liter full cream, kemasan karton belum dibuka sama sekali. Sisa stok minimarket (overstock). Kualitas susu masih terjaga, cocok untuk diminum langsung atau campuran kopi.",
            "Kue kacang toples kecil buatan rumahan (homemade), tekstur lumer di mulut dengan rasa gurih manis yang pas. Tanpa pengawet, cocok untuk teman ngemil saat santai.",
            "Keripik kentang rasa original kemasan besar (party size). Masih segel kembung, sisa hampers lebaran yang tidak dimakan. Renyah dan gurih, pas untuk camilan nonton film.",
            "Jus jeruk murni 100% tanpa gula tambahan dan tanpa pengawet. Botol 250ml sisa produksi cold press juice hari ini. Kaya vitamin C, wajib segera disimpan di kulkas atau langsung diminum.",
            "Air mineral botol besar 1.5 liter, segel tutup masih terkunci rapat. Sisa konsumsi acara event lari yang tidak terdistribusi. Air minum bersih dan higienis untuk stok di rumah.",
            "Susu formula bayi tahap 1, kaleng 400g, kondisi kaleng mulus tidak penyok dan segel alumunium di dalam masih utuh. Dijual karena salah beli merek, exp date masih sangat panjang.",
            "Bubur bayi instan rasa pisang, kemasan pouch praktis siap seduh. Kondisi baru, dijual karena sisa stok anak yang sudah naik tekstur makanan. Solusi MPASI praktis saat traveling.",
            "Mie instan goreng isi 5 bungkus (multipack), kemasan luar utuh tidak robek. Sisa stok pantry kantor yang berlebih. Makanan darurat paling praktis dan favorit semua orang.",
            "Ikan tuna kaleng (chunk) dalam minyak nabati, kondisi kaleng bagus tidak ada karat atau penyok. Expired date masih lama. Praktis untuk campuran nasi goreng, sandwich, atau salad.",
            "Madu hutan asli 250ml dalam botol kaca tebal. Masih segel plastik, dijamin murni. Merupakan sisa oleh-oleh yang kelebihan. Sangat baik untuk menjaga imunitas tubuh atau pengganti gula.",
            "Sereal jagung (corn flakes) box besar, kemasan dalam belum pernah dibuka. Sisa stok sarapan hotel, kualitas premium. Sarapan praktis, tinggal tuang susu cair."
        ];

        $foodList = [
            'Bakery' => ['Whole Wheat Bread', 'Croissant', 'Chocolate Muffin'],
            'Rice' => ['Nasi Goreng', 'Nasi Kuning Box', 'Chicken Teriyaki Rice'],
            'Meat' => ['Beef Rendang', 'Grilled Chicken Breast', 'Fish Fillet Meal'],
            'Fruits' => ['Fresh Apples Pack', 'Bananas', 'Fruit Salad Cup'],
            'Vegetables' => ['Mixed Salad Bowl', 'Fresh Lettuce Head', 'Vegetable Stir Fry'],
            'Dairy' => ['Yogurt Cup', 'Cheddar Cheese Slices', 'Milk Carton (1L)'],
            'Snacks' => ['Peanut Cookies', 'Potato Chips Bag'],
            'Drinks' => ['Orange Juice Bottle', 'Mineral Water (1.5L)'],
            'Baby Food' => ['Baby Formula Powder', 'Mashed Banana Baby Pouch'],
            'Packaged Food' => ['Instant Noodles 5-Pack', 'Canned Tuna'],
            'Others' => ['Honey Jar', 'Cereal Box'],
        ];

        $indoAddresses = [
           'RW 02, Gambir, Central Jakarta, Special Capital Region of Jakarta',
           'Jalan Petojo Sabangan X, RW 04, Petojo Selatan, Gambir, Central Jakarta',
           'Jalan Serdang Baru, RW 04, Serdang, Kemayoran, Central Jakarta',
           'Jalan Cempaka Putih Tengah, RW 05, Cempaka Putih, Central Jakarta',
           'Jalan Tanah Abang II, RW 01, Tanah Abang, Central Jakarta',
           'Jalan Cibodas Raya, Karawaci Baru, Karawaci, Tangerang, Banten',
           'Jalan Imam Bonjol, Karawaci Ilir, Tangerang, Banten',
           'Jalan Merdeka Raya, Cikokol, Tangerang, Banten',
           'Graha Indah 2, Villa Taman Kartini, Bekasi, West Java',
           'Jalan Ahmad Yani, Bekasi Timur, Bekasi, West Java',
           'Jalan Pekayon Raya, Pekayon Jaya, Bekasi Selatan, West Java',
           'Jalan Cemara 4, Central Park Cikarang, Waluya, Bekasi, West Java',
           'Jalan Raya Lemah Abang, Karangsambung, Bekasi, West Java, 17540',
           'Jalan Industri Selatan, Jababeka, Cikarang, West Java',
           'Jalan Diponegoro, Coblong, Bandung, West Java',
           'Jalan Braga, Braga, Sumur Bandung, Bandung, West Java',
           'Jalan Setiabudi, Ledeng, Bandung, West Java',
           'Jalan Kaliurang KM 6, Sleman, Special Region of Yogyakarta',
           'Jalan Malioboro, Sosromenduran, Yogyakarta',
           'Jalan Parangtritis, Bantul, Special Region of Yogyakarta',
           'Jalan Ahmad Dahlan, Tegalsari, Surabaya, East Java',
           'Jalan Raya Darmo, Wonokromo, Surabaya, East Java',
           'Jalan Kenjeran, Tambaksari, Surabaya, East Java',
           'Jalan Teuku Umar, Denpasar Barat, Bali',
           'Jalan Gatot Subroto Barat, Denpasar, Bali',
           'Jalan Sunset Road, Kuta, Badung, Bali'
        ];

        $index = 1;
        $descIndex = 0;

        foreach ($foodList as $category => $foods) {
            foreach ($foods as $food) {

                DB::table('food_items')->insert([
                    'user_id' => $faker->randomElement($users),
                    'category_id' => $categoryMap[$category],
                    'name' => $food,
                    
                    'description' => $manualDescriptions[$descIndex], 
                    
                    'photo' => "images/sample-$index.jpg",
                    'quantity' => rand(1, 10),
                    'pickup_location' => $faker->randomElement($indoAddresses),
                    'pickup_time' => $faker->randomElement([
                        '09.00 - 12.00 WIB', 
                        '13.00 - 15.00 WIB', 
                        '16.00 - 20.00 WIB', 
                        'Bebas (Hubungi via WA)'
                    ]),
                    'expires_at' => $faker->dateTimeBetween('now', '+6 days'),
                    'status' => 'available',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $index++;
                $descIndex++;
            }
        }
    }
}