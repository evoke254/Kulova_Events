<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    public $fillable = [
        'campaign_template_id',


        'template_type',
        'body',
        'parent_id',
        'name',
        'user_id',
        'subject',
        'logo',

        'heading',
        'paragraph',
        'button_text',
        'cta_link',
        'is_active',
        'footer'
    ];
}



