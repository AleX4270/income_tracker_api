<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IncomeCategoryTranslation;
use App\Models\IncomeCategory;
use App\Models\Language;
use App\Types\LanguageType;

class IncomeCategoryTranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void {
        $otherCategory = IncomeCategory::where('symbol', 'other')->first();
        $polishLanguageId = Language::where('symbol', LanguageType::PL)->first()->id;

        if(!empty($otherCategory) && !empty($polishLanguageId)) {
            IncomeCategoryTranslation::firstOrCreate(
                ['income_category_id' => $otherCategory->id, 'name' => 'Inne'],
                [
                    'income_category_id' => $otherCategory->id,
                    'language_id' => $polishLanguageId,
                    'name' => 'Inne',
                    'description' => 'Podstawowa kategoria systemowa.'
                ]
            );
        }
    }
}
