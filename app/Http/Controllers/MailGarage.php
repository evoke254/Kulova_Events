<?php

namespace App\Http\Controllers;

use App\Mail\Phishingmail;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class MailGarage extends Controller
{
    //

    public function render(EmailTemplate $emailTemplate){

    return new Phishingmail($emailTemplate);
    }
}
