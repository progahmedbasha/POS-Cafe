<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function getImageAttribute()
    {
        return 'data/dashboard/products';
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
