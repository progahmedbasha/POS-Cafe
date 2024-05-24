<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
     protected static function boot()
    {
        parent::boot();

        static::deleted(function ($orderItem) {
            // Check if the associated Order doesn't have any more OrderItems
            if ($orderItem->order->whereDoesntHave('orderItems')->where('type', 1)->exists()) {
                // Delete the Order
                $orderItem->order->delete();
            }
        });
    }
}