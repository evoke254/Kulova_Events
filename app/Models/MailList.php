<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailList extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'department',
        'mail',
        'phone',
        'status',
        'organization_id',
        'organization_department_id',
        'parent_id'
    ];
}
