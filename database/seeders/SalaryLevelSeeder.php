<?php

namespace Database\Seeders;

use App\Models\SalaryLevel;
use Illuminate\Database\Seeder;

class SalaryLevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['level' => 'Junior', 'gaji_min' => 5000000, 'gaji_max' => 10000000],
            ['level' => 'Staff', 'gaji_min' => 10000000, 'gaji_max' => 15000000],
            ['level' => 'Senior', 'gaji_min' => 15000000, 'gaji_max' => 22000000],
            ['level' => 'Manager', 'gaji_min' => 22000000, 'gaji_max' => 35000000],
            ['level' => 'Grand Manager', 'gaji_min' => 35000000, 'gaji_max' => 50000000],
        ];

        foreach ($levels as $item) {
            SalaryLevel::updateOrCreate(['level' => $item['level']], $item);
        }
    }
}
