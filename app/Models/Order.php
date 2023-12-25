<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

        protected $fillable =[
        'payment_method',
        'tickets',
        'user_id',
        'event_id',
        'amount',
        'job_id',
        'status',
    ];
}
