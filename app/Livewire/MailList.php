<?php

namespace App\Livewire;

use Livewire\Component;

class MailList extends Component
{
    public $emails;
    public $success;

    public function mount(){
        $this->emails = \App\Models\MailList::orderBy('created_at', 'DESC')->get();
    }

    public function updateStatus(\App\Models\MailList $mail_list){

        $mail_list->status = !$mail_list->status;
        $mail_list->save();
        $this->success = ['Status updated'];

    }
    public function clearSuccess(){
        $this->success = null;
    }

    public function render()
    {
        return view('livewire.mail-list');
    }
}
