<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    public function grades(): HasMany
    {
        return $this->hasMany(Grade::class);
    }
}
