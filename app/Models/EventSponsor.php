<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventSponsor extends Model
{
    use HasFactory;

    protected $fillable = ['sponsor', 'event_id', 'topic', 'image'];

}
