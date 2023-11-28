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
        'photo'
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
}
