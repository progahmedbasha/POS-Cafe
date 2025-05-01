<?php

namespace App\Models;

use App\Models\User;
use Spatie\Activitylog\Models\Activity as SpatieActivity;

class Activity extends SpatieActivity
{
   
    public function user()
    {
        $databaseName = config('database.connections.mysql.database');
        return $this->belongsTo(User::class, 'causer_id', 'id')
                        ->from("{$databaseName}.users"); // Assuming 'id' is the key in the 'users' table
    }

}
