<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    const STATUS_UNTOUCHED = 'untouched';
    const STATUS_ABSENT = 'absent';

    protected $table = 'student_grade';
}
