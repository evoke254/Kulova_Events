<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function variants(): HasMany
    {
        return $this->hasMany(EventMerchandise::class, 'parent_id', 'id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (isset($model->parent_id)){
                $parent = EventMerchandise::find($model->parent_id);
                $model->event_id = $parent->event_id;

            }
        });
    }
}
