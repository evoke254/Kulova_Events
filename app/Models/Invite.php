<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function allUserVotes(): HasMany
    {
        return $this->HasMany(Vote::class);
    }


    public function castVote($elective_position_id , $candidate_elective_position_id)
    {
        return Vote::where('elective_position_id',  $elective_position_id)
            ->where('candidate_elective_position_id', $candidate_elective_position_id)
            ->where('invite_id', $this->id)
            ->first();
    }

    public function castVoteInPstn($elective_position_id)
    {
        return Vote::where('elective_position_id',  $elective_position_id)
            ->where('invite_id', $this->id)
            ->first();
    }





}
