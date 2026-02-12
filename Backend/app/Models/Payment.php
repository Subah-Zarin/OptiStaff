<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'month',
    'basic_salary',
    'absent_days',
    'deduction',
    'final_salary',
    'status',
    'paid_at'
];

protected $casts = [
    'paid_at' => 'datetime',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];


   public function user()
{
    return $this->belongsTo(User::class);
}

}
