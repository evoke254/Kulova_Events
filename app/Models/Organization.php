<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Organization extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'location',
        'description',
        'phone_number',
        'lat',
        'long',
    ];



    public function departments(): HasMany
    {
        return $this->hasMany(OrganizationDepartment::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

        public function elections(): HasMany
    {
        return $this->hasMany(Election::class);
    }
}
