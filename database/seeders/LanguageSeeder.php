<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Language;
use App\Types\LanguageType;

class LanguageSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Language::firstOrCreate(
            ['symbol' => LanguageType::EN],
            [
                'symbol' => LanguageType::PL,
                'name' => 'Polski'
            ]
        );

        Language::firstOrCreate(
            ['symbol' => LanguageType::EN],
            [
                'symbol' => LanguageType::EN,
                'name' => 'English'
            ]
        );
    }
}
