<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IncomeCategoryTranslation extends Model {
    use HasFactory;

    protected $table = 'income_category_translation';
    public $timestamps = false;

    public function category(): BelongsTo {
        return $this->belongsTo(IncomeCategory::class);
    }
}
