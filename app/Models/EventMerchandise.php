<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventMerchandise extends Model
{
    use HasFactory;
    protected $fillable =[
        'name', 'description','parent_id', 'attribute', 'value', 'event_id'
    ];

    public function elections(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
}
