<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([
            'name' => '1',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '2',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '3',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '4',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '5',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '6',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '7',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '8',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '9',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '10',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '11',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '12',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => '13',
            'type' => '1',
        ]);
        DB::table('services')->insert([
            'name' => 'r1',
            'type' => '2',
            'ps_price' => '60',
            'ps_type' => 5
        ]);
        DB::table('services')->insert([
            'name' => 'r2',
            'type' => '2',
            'ps_price' => '60',
            'ps_type' => 5
        ]);
        DB::table('services')->insert([
            'name' => 'r3',
            'type' => '2',
            'ps_price' => '40',
            'ps_type' => 4
        ]);
        DB::table('services')->insert([
            'name' => 'r4',
            'type' => '2',
            'ps_price' => '60',
            'ps_type' => 5
        ]);
        DB::table('services')->insert([
            'name' => 'r5',
            'type' => '2',
            'ps_price' => '40',
            'ps_type' => 4
        ]);
        DB::table('services')->insert([
            'name' => 'r6',
            'type' => '2',
            'ps_price' => '40',
            'ps_type' => 4
        ]);
    }
}