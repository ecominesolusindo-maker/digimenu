<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    protected $guarded = ['id'];

    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory;
}
