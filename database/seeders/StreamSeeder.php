<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StreamSeeder extends Seeder
{
    public function run()
    {
        $streams = [
            ['name' => 'General', 'desc' => 'ከ KG እስከ 8ኛ ክፍል'],
            ['name' => 'Natural Science', 'desc' => 'የተፈጥሮ ሳይንስ ዘርፍ (9 - 12)'],
            ['name' => 'Social Science', 'desc' => 'የማህበራዊ ሳይንስ ዘርፍ (9 - 12)'],
        ];

        foreach ($streams as $stream) {
            DB::table('streams')->insert([
                'stream_name' => $stream['name'],
                'description' => $stream['desc'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
