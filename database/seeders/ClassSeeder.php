<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            ['label' => 'KG 1', 'priority' => 1],
            ['label' => 'KG 2', 'priority' => 2],
            ['label' => 'KG 3', 'priority' => 3],
            ['label' => 'Grade 1', 'priority' => 4],
            ['label' => 'Grade 2', 'priority' => 5],
            ['label' => 'Grade 3', 'priority' => 6],
            ['label' => 'Grade 4', 'priority' => 7],
            ['label' => 'Grade 5', 'priority' => 8],
            ['label' => 'Grade 6', 'priority' => 9],
            ['label' => 'Grade 7', 'priority' => 10],
            ['label' => 'Grade 8', 'priority' => 11],
            ['label' => 'Grade 9', 'priority' => 12],
            ['label' => 'Grade 10', 'priority' => 13],
            ['label' => 'Grade 11', 'priority' => 14],
            ['label' => 'Grade 12', 'priority' => 15],
        ];

        foreach ($classes as $class) {
            DB::table('classes')->insert([
                'class_label' => $class['label'],
                'priority' => $class['priority'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
