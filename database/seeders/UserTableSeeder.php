<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        DB::table('admins')->insert([
         [
            'name' => 'Admin',
            'email' => 'admin@sales.com',
            'password' =>Hash::make('admin@sales.com'),
            'created_at' => '2025-02-08',
         ]  

        ]);
    }
}
