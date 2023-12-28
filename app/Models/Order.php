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
        'email',
        'name',
        'phone_number',
        'status',
    ];
}
