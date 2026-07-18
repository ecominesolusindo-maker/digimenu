<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class Reservation extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    protected $casts = ['reservation_time' => 'datetime'];

    public function table() { return $this->belongsTo(Table::class); }
}
