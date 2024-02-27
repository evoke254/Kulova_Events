<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class EventAgenda extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'event_id', 'name'];
}
