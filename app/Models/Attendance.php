<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['check_in_at' => 'datetime', 'check_out_at' => 'datetime'];

    public function staff() { return $this->belongsTo(StaffProfile::class, 'staff_id'); }
}
