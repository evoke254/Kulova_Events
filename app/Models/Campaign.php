<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable =[
        'name', 'email', 'url', 'start_date', 'end_date', 'organization_id',
        'organization_department_id',
        'email_template_id',
        'mail_list_id',
        'user_id',
        'landing_page_id',
    ];
}
