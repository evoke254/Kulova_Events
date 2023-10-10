<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invite extends Model
{
    use HasFactory;
        protected $fillable = [
        'event_id',
        'name',
        'last_name',
        'phone_number',
        'email',
        'member_no',
        'details'
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
