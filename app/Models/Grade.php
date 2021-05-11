<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'student_id',
        'value',
        'status'
    ];

    const STATUS_UNTOUCHED = 'untouched';
    const STATUS_TOUCHED = 'touched';
    const STATUS_ABSENT = 'absent';

    protected $table = 'student_grade';
    public $timestamps = false;

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
