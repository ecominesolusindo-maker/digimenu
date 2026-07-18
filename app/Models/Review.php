<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class Review extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    public function order() { return $this->belongsTo(Order::class); }
}
