<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'name' => 'coffe',
            'price' => '100',
        ]);
        DB::table('products')->insert([
            'name' => 'Tea',
            'price' => '200',
        ]);
        DB::table('products')->insert([
            'name' => 'water',
            'price' => '200',
        ]);
        DB::table('products')->insert([
            'name' => 'ice coffe',
            'price' => '200',
        ]);
        DB::table('products')->insert([
            'name' => 'soda 1',
            'price' => '200',
            'category_id' => '1'
        ]);
        DB::table('products')->insert([
            'name' => 'soda 2',
            'price' => '200',
            'category_id' => '1'
        ]);
        DB::table('products')->insert([
            'name' => 'soda 3',
            'price' => '200',
            'category_id' => '1'
        ]);
    }
}