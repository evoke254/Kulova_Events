<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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
    public function positions()
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

    public function getTotalVotesAttribute()
    {
        $votes = DB::table('elections')
            ->join('elective_positions', 'elections.id', '=', 'elective_positions.election_id')
            ->join('candidate_elective_positions', 'elective_positions.id', '=', 'candidate_elective_positions.elective_position_id')
            ->join('votes', 'candidate_elective_positions.id', '=', 'votes.candidate_elective_position_id')
            ->where('elections.id', $this->id)
            ->distinct('votes.id')
            ->count('votes.id');

        return $votes .'/'. $this->event()->first()->invites()->count();
    }


    public function getPercentageVotesCastAttribute()
    {
        $votes = DB::table('elections')
            ->join('elective_positions', 'elections.id', '=', 'elective_positions.election_id')
            ->join('candidate_elective_positions', 'elective_positions.id', '=', 'candidate_elective_positions.elective_position_id')
            ->join('votes', 'candidate_elective_positions.id', '=', 'votes.candidate_elective_position_id')
            ->where('elections.id', $this->id)
            ->distinct('votes.id')
            ->count('votes.id');

        return round(($votes / ($this->event()->first()->invites()->count()) * 100), 1) . '%';

    }

}
