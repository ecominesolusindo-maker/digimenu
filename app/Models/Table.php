<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class Table extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::creating(function ($table) {
            if (empty($table->qr_code_token)) {
                $table->qr_code_token = \Illuminate\Support\Str::random(10);
            }
        });
    }
}
