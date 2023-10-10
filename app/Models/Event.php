<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    protected $fillable =[
        'name', 'description','venue', 'organization_id', 'is_active', 'is_featured', 'user_id',
        'cost', 'start_date', 'end_date'
    ];

    protected $with = ['organization', 'invites', 'elections'];

    protected $dates = ['start_date', 'end_date'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }

        public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

}
