<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function scopeWhenSearch($query,$search){
        return $query->when($search,function($q)use($search){
            return $q->where('name','like',"%$search%");
        });
    }
    public function getImageAttribute()
    {
        return 'data/dashboard/products';
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function countOrders()
    {
        return $this->orderItems()->sum('qty');
    }
    public function totalSales()
    {
        return $this->orderItems()->sum('total_cost');
    }
}