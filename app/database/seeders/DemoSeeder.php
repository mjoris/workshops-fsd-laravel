<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // just for demo purposes ... not really part of the DB model
        DB::table('users')->insert([
            'name' => Str::random(10),
            'email' => 'theboss@gmail.com',
            'password' => Hash::make('Azerty123'),
            // 'role' => 'admin'
        ]);

        DB::table('products')->insert([
            'name' => 'OnePlus 8',
            'description' => 'Een leuke Smartphone.',
            'price' => '499.99',
            'brand_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('categories')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('categories')->insert([
            'name' => Str::random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
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
