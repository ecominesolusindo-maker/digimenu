<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class LoyaltyPoint extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];
}
