<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;
    const ELECTION_TYPE = [1 => 'Candidate Election', 2 =>'Resolution Election'];

    protected $fillable = [
        'name', 'event_id', 'details', 'election_date', 'type', 'user_id', 'organization_id', 'status'
    ];

    protected $with = ['elective_positions'];
    protected $appends = ['elct_type'];


    public function elective_positions():HasMany
    {
        return $this->hasmany(ElectivePosition::class);
    }

    public function event():belongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function organization():belongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function getElctTypeAttribute()
    {
        return  isset($this->type) ? self::ELECTION_TYPE [$this->type] : ' ';
    }

}
