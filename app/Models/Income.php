<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Income extends Model {
    use HasFactory;

    protected $table = 'income';

    protected $attributes = [
        'is_active' => 1
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function currency(): BelongsTo {
        return $this->belongsTo(Currency::class);
    }

    //test if it's correct
    public function categories(): BelongsToMany {
        return $this->belongsToMany(IncomeCategory::class, 'income_category_income', 'income_id', 'income_category_id');
    }
}
