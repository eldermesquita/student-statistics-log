<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $casts = [
        'last_activity' => 'datetime:d-m-Y в H:i',
    ];
}
