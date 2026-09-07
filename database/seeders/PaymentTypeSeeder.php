<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            ['name' => 'ወርሃዊ የትምህርት ክፍያ', 'desc' => 'መደበኛ የወር ክፍያ'],
            ['name' => 'የምዝገባ ክፍያ', 'desc' => 'የዓመታዊ ምዝገባ ክፍያ'],
            ['name' => 'የትራንስፖርት/ሰርቪስ ክፍያ', 'desc' => 'የተማሪዎች የትራንስፖርት ክፍያ'],
            ['name' => 'የማጠናከሪያ ትምህርት (Tutorial)', 'desc' => 'የትምህርት ድጋፍ ክፍያ'],
            ['name' => 'የትምህርት ጉዞ (School Trip)', 'desc' => 'የትምህርታዊ ጉብኝት ክፍያ'],
            ['name' => 'የምረቃ ክፍያ (Graduation)', 'desc' => 'የመመረቂያ ዝግጅት ክፍያ'],
        ];

        foreach ($types as $type) {
            DB::table('payment_types')->insert([
                'payment_type_name' => $type['name'],
                'description' => $type['desc'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
