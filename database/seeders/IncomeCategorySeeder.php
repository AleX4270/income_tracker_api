<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IncomeCategory;

class IncomeCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        IncomeCategory::firstOrCreate(
            ['symbol' => 'other'],
            [
                'symbol' => 'other'
            ]
        );
    }
}
