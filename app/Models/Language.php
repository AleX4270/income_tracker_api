<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model {
    use HasFactory;

    public $timestamps = false;
    protected $table = 'language';

    protected $attributes = [
        'is_active' => 1
    ];
}