<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Tags\HasTags;

class Event extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasTags;

    protected $fillable =[
        'name', 'description','venue', 'organization_id', 'is_active', 'is_featured', 'user_id',
        'cost', 'start_date', 'end_date', 'event_category_id'
    ];

    protected $casts = [];
    protected $with = ['organization', 'invites', 'elections'];

    protected $dates = ['start_date', 'end_date'];

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }


    public function invites(): HasMany
    {
        return $this->hasMany(Invite::class);
    }



    public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }

        public function images(): HasMany
    {
        return $this->hasMany(EventImage::class);
    }
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }



    public static function getTagClassName(): string
    {
        return EventCategory::class;
    }
    public function tags(): MorphToMany
    {
        return $this
            ->morphToMany(self::getTagClassName(), 'taggable', 'taggables', null, 'tag_id')
            ->orderBy('created_at');
    }

}
