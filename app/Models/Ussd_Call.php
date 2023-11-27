<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ussd_Call extends Model
{
    use HasFactory;

    protected $fillable = [
        'phoneNumber',
        'serviceCode',
        'sessionId',
        'text',
    ];
}
