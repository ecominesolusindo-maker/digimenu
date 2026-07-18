<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class StaffProfile extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    public function user() { return $this->belongsTo(User::class); }
    public function attendances() { return $this->hasMany(Attendance::class, 'staff_id'); }
}
