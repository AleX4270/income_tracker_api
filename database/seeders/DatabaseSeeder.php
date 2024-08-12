<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\CurrencySeeder;
use Database\Seeders\IncomeCategorySeeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        $this->call([
            UserSeeder::class,
            LanguageSeeder::class,
            CurrencySeeder::class,
            IncomeCategorySeeder::class
        ]);
    }
}
