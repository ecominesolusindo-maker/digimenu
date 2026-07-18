<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class InventoryItem extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    public function transactions() { return $this->hasMany(InventoryTransaction::class); }
}
