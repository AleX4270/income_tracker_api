<?php

namespace App\Models;

use App\Types\LanguageType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class IncomeCategory extends Model {
    use HasFactory;

    protected $table = 'income_category';
    protected $attributes = [
        'is_active' => 1
    ];

    public function translation(): HasOne {
        return $this->hasOne(IncomeCategoryTranslation::class)
                    ->where('language_id', Language::where('symbol', app()->getLocale())->first()->id);
    }

    //test if it's correct
    public function incomes(): BelongsToMany {
        return $this->belongsToMany(Income::class, 'income_category_income', 'income_category_id', 'income_id');
    }
}
