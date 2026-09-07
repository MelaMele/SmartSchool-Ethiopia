<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssasmenetSeeder extends Seeder
{
    public function run()
    {
        $assessments = [
            ['type' => 'Test 1', 'weight' => 10],
            ['type' => 'Test 2', 'weight' => 10],
            ['type' => 'Quiz', 'weight' => 5],
            ['type' => 'Mid Exam', 'weight' => 20],
            ['type' => 'Assignment', 'weight' => 10],
            ['type' => 'Worksheet', 'weight' => 5],
            ['type' => 'Final Exam', 'weight' => 40],
            ['type' => 'Model Exam', 'weight' => 100],
        ];

        foreach ($assessments as $item) {
            DB::table('assasment_types')->insert([
                'assasment_type' => $item['type'],
                'max_mark' => 100,
                'weight' => $item['weight'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
