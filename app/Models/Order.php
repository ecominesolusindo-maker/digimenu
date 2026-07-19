<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\BelongsToRestaurant;

class Order extends Model
{
    use HasFactory, BelongsToRestaurant;

    protected $guarded = ['id'];

    public function items() { return $this->hasMany(OrderItem::class); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function table() { return $this->belongsTo(Table::class); }
    public function statusLogs() { return $this->hasMany(OrderStatusLog::class); }
    public function payment() { return $this->hasOne(Payment::class); }
    public function delivery() { return $this->hasOne(Delivery::class); }
    public function review() { return $this->hasOne(Review::class); }
}
