<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Currency;
use App\Types\CurrencyType;

use function PHPSTORM_META\map;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Currency::firstOrCreate(
            ['symbol' => CurrencyType::PLN],
            [
                'symbol' => CurrencyType::PLN,
                'short_symbol' => 'zł'
            ]
        );

        Currency::firstOrCreate(
            ['symbol' => CurrencyType::EUR],
            [
                'symbol' => CurrencyType::EUR,
                'short_symbol' => '€'
            ]
        );
    }
}
