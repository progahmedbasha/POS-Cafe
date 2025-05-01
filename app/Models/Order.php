<?php

namespace App\Models;

use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, LogsActivity, SoftDeletes;

    protected $dates = ['start_time'];

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function orderTimes()
    {
        return $this->hasMany(OrderTime::class);
    }
    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['id', 'number', 'user_id', 'total_price'])
            ->logOnlyDirty()
            ->useLogName('orders')
            ->setDescriptionForEvent(fn(string $eventName) => "تم {$eventName} الطلب");
    }
}