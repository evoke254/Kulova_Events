<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CandidateElectivePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_no',
        'elective_position_id',
        'photo',
        'election_id'
    ];

    protected $with =['votes'];

    public function elective_position(): BelongsTo
    {
        return $this->belongsTo(ElectivePosition::class);
    }

    public function votes():HasMany
    {
        return $this->hasmany(Vote::class);
    }

    public function getVotesCountAttribute()
    {
        $votes =        $this->hasmany(Vote::class)->get()->count();
        return $votes;
    }

    public function getPercentageVotesAttribute()
    {
        $totalVotes = $this->elective_position()->first()->votes()->count();

        if ($totalVotes){
            return ($this->getVotesCountAttribute()/$totalVotes )* 100  . ' %';
        }
        return '0 %';

    }



}
