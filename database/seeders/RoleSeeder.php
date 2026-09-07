<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin', 'display_name' => 'ዋና አስተዳዳሪ (Super Admin)', 'description' => 'የትምህርት ቤቱ ሙሉ ባለስልጣን'],
            ['name' => 'teacher', 'display_name' => 'መምህር (Teacher)', 'description' => 'ውጤት እና አቴንዳንስ መመዝገቢያ'],
            ['name' => 'finance', 'display_name' => 'የሂሳብ ክፍል (Finance / Cashier)', 'description' => 'የትምህርት እና ሰርቪስ ክፍያ ተቀባይ'],
            ['name' => 'parent', 'display_name' => 'ወላጅ (Parent)', 'description' => 'የተማሪዎችን ውጤት እና ክፍያ መከታተያ'],
            ['name' => 'student', 'display_name' => 'ተማሪ (Student)', 'description' => 'የተማሪ ገጽ'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert([
                'name' => $role['name'],
                'display_name' => $role['display_name'],
                'description' => $role['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
