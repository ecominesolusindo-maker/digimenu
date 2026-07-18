<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryTransaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function item() { return $this->belongsTo(InventoryItem::class, 'inventory_item_id'); }
    public function order() { return $this->belongsTo(Order::class, 'related_order_id'); }
}
