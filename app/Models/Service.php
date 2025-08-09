<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function isActive()
    {
        return Order::where('service_id', $this->id)->where('status', 1)->exists();
    }
}