<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class MenuCategory extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    public function items() { return $this->hasMany(MenuItem::class, 'category_id'); }
}
