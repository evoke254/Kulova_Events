<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Election extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'event_id', 'details', 'election_date'
    ];

    protected $with = ['elective_positions'];


    public function elective_positions():HasMany
    {
        return $this->hasmany(ElectivePosition::class);
    }

}
