<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'leave_type',
        'duration',       
        'half_day_type', 
        'from_date',
        'to_date',
        'number_of_days',
        'status',
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }


}
