<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model {
    use HasFactory;

    public $timestamps = false;
    protected $table = 'currency';

    protected $attributes = [
        'is_active' => 1
    ];
}
