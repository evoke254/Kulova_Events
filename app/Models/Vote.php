<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vote extends Model
{
    use HasFactory;

    protected $fillable = [
        'elective_position_id',
        'candidate_elective_position_id',
        'invite_id',
        'vote',
    ];
    protected $with = ['position', 'candidate'];
    public function position(): BelongsTo
    {
        return $this->belongsTo(ElectivePosition::class);
    }

        public function candidate(): BelongsTo
    {
        return $this->belongsTo(CandidateElectivePosition::class);
    }

            public function user(): BelongsTo
    {
        return $this->belongsTo(Invite::class);
    }
}
