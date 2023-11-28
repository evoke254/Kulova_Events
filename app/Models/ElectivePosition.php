<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ElectivePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'votes',
        'election_id'
    ];

    protected $with = ['candidates', 'vote'];

    public function candidates():HasMany
    {
        return $this->hasmany(CandidateElectivePosition::class);
    }

        public function vote():HasOne
    {
        return $this->hasOne(Vote::class);
    }

     public function election(): BelongsTo
    {
        return $this->belongsTo(Election::class);
    }


}
