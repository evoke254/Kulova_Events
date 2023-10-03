<?php

namespace App\Livewire\MailTemplate;

use App\Models\EmailTemplate;
use Livewire\Component;

class ListMailTemplates extends Component
{
    public $mail_templates;
    public $success;

    public function mount(){
        $this->mail_templates = EmailTemplate::orderBy('created_at', 'DESC')->get();
    }

    public function updateStatus(EmailTemplate $email_template){
        $email_template->is_active = !$email_template->is_active;
        $email_template->save();
        $this->success = ['Status updated'];
    }
    public function render()
    {
        return view('livewire.mail-template.list-mail-templates');
    }
}
