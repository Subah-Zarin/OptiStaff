<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLock extends Model
{
    use HasFactory;

    protected $fillable = ['lock_date', 'is_locked'];

    protected $casts = [
        'lock_date' => 'date',
        'is_locked' => 'boolean',
    ];
}