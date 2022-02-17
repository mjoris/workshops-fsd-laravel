<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

// Migration for concluding demo 'webshop' of 05.auth
class DemoSeederWithAuth extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('brands')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        // new !
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'theboss@gmail.com',
            'password' => Hash::make('Azerty123'),
            'role' => 'admin'
        ]);

        DB::table('products')->insert([
            'name' => 'OnePlus 8',
            'description' => 'Een leuke Smartphone.',
            'price' => '499.99',
            'brand_id' => 1,
            'user_id' => 1, // new !
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('categories')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('category_product')->insert([
            'category_id' => 1,
            'product_id' => 1,
        ]);

        DB::table('category_product')->insert([
            'category_id' => 2,
            'product_id' => 1,
        ]);

    }
}
