<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Spatie\Tags\HasTags;
use Spatie\Tags\Tag;

class EventCategory extends Model
{
    use HasFactory, HasTags;

        protected $fillable =[
        'name', 'description',
    ];



        public function events(): MorphToMany
    {
        return $this->morphedByMany(Event::class, 'taggable' , 'taggables', 'tag_id');
    }



    public static function findOrCreate($tags, $type = null){
        return Tag::findOrCreate($tags);

    }

    public static function findFromString($name){
        return Tag::findFromString($name);

    }
}
