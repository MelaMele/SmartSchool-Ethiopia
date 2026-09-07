<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        // ዋናውን የአድሚን አካውንት መፍጠር
        DB::table('users')->insert([
            'name' => 'Super Administrator',
            'email' => 'admin@smartschool.et',
            'user_id' => 'ADM-001',
            'role_id' => 1, // Admin Role
            'password' => Hash::make('Admin@123456'), // የይለፍ ቃል
            'is_active' => true,
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
