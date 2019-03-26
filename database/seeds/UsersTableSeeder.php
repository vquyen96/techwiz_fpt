<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        DB::table('users')->insert([
            'name' => 'RMT Admin',
            'email' => 'admin@rmt.com',
            'password' => Hash::make('Admin@123'),
            'description' => '',
            'avatar_url' => '',
            'role' => 1,
            'tel' => '',
            'created_at' => $now,
            'updated_at' => $now,
            'verified' => 1,
            'status' => 1,
            'id' => uniqid()
        ]);

        DB::table('users')->insert([
            'name' => 'RMT User',
            'email' => 'rmt.hblab@gmail.com',
            'password' => Hash::make('User@123'),
            'description' => '',
            'avatar_url' => '',
            'role' => 0,
            'tel' => '',
            'created_at' => $now,
            'updated_at' => $now,
            'verified' => 1,
            'status' => 1,
            'id' => uniqid()
        ]);
    }
}
