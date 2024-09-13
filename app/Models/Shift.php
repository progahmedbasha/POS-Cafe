<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getType()
    {
        if ($this->type == 1){
            return 'صباحي';
        } elseif ($this->type == 2) {
            return 'مسائي';
        } elseif ($this->type == 3) {
            return 'الادارة';
        }
    }
}