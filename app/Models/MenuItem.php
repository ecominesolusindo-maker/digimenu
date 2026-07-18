<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class MenuItem extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    protected $casts = ['variants' => 'array', 'addons' => 'array'];

    public function category() { return $this->belongsTo(MenuCategory::class); }
}
