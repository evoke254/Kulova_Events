<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LandingPage extends Model
{
    use HasFactory;

    public $fillable = [
        'body',
        'parent_id',
        'campaign_template_id',
        'title',
        'grapes'
    ];



    public function template(): BelongsTo
    {
        return $this->belongsTo(CampaignTemplate::class);
    }

}
