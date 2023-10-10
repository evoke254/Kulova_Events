<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CandidateElectivePosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'member_no',
        'elective_position_id',
        'photo'
    ];

    public function elective_position(): BelongsTo
    {
        return $this->belongsTo(ElectivePosition::class);
    }
}
