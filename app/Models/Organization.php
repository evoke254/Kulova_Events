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

}
