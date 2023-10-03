<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CampaignTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'permission',
        'is_active',
    ];

    protected $with = ['page', 'user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

        public function page(): HasOne
    {
        return $this->HasOne(LandingPage::class);
    }



}
