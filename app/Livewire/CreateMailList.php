<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CreateMailList extends Component
{
    public $mailList;
    public  $parent_id;
    public $first_name;
    public $last_name;
    public $status;
    public $error;
    public $department;
    public $mail;
    public $phone;
    public $organization_id;
    public $organization_department_id;
    protected $rules = [
        'first_name' => 'required|min:2',
        'mail' => 'required|email|unique:mail_lists,mail',
    ];


    public function addUserMail() {

        $this->validate();

        $mail_list = \App\Models\MailList::updateOrCreate(
            ['id' => isset($this->mailList->id) ? $this->mailList->id : null],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'mail' => $this->mail,
                'phone' => $this->phone,
                'status' => $this->status,
                'organization_id' => $this->organization_id,
                'organization_department_id' => $this->organization_department_id,
                'parent_id' => Auth::id()
            ]
        );


        return redirect()->route('mail_list.index')->with('success', true);
    }

    public function mount($mailList = null) {
        $this->mailList = $mailList;
        $this->status = true;
        if ($this->mailList){
                $this->first_name = $this->mailList->first_name;
                $this->last_name = $this->mailList->last_name;
                $this->mail = $this->mailList->mail;
                $this->phone = $this->mailList->phone;
                $this->status = $this->mailList->status;
                $this->organization_id = $this->mailList->organization_id;
                $this->organization_department_id = $this->mailList->organization_department_id;
                $this->parent_id = Auth::id();
        }
    }

    public function updateStatus(){

        $this->status =  !$this->status;

    }
    public function render()
    {
        return view('livewire.create-mail-list');
    }
}
