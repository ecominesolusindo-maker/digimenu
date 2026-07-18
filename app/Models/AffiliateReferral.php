<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateReferral extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function affiliate() { return $this->belongsTo(Affiliate::class); }
    public function restaurant() { return $this->belongsTo(Restaurant::class, 'referred_restaurant_id'); }
}
