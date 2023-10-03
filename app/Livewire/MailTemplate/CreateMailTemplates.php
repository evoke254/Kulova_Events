<?php

namespace App\Livewire\MailTemplate;

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;


class CreateMailTemplates extends Component
{

    use WithFileUploads;
    public $name;
    public $template;
    public $parent_id;
    public $body;
    public $error;
    public $logo;
    public $heading;
    public $subject;
    public $user_id;
    public $is_active;
    public $paragraph;
    public $footer;
    public $button_text;
    public $cta_link;

    protected $rules = [
        'name' => 'required|min:2',
        'subject' => 'required|min:2',
        'body' => 'required',
//        'heading' => 'required',
//        'logo' => 'image'
    ];
    public function mount($emailTemplate = null){

        $this->template  = $emailTemplate;
        $this->is_active = true;
        if ($this->template){
            $this->user_id = $this->template->user_id;
            $this->name = $this->template->name;
            $this->subject = $this->template->subject;
            $this->body = $this->template->body;
            $this->is_active = $this->template->is_active;
            $this->parent_id = $this->template->parent_id;
/*
            $this->logo = $this->template->logo;
            $this->heading = $this->template->heading;
            $this->paragraph = $this->template->paragraph;
            $this->button_text = $this->template->button_text;
            $this->cta_link = $this->template->cta_link;
            $this->footer = $this->template->footer;*/
        }

    }

    public function createTemplate() {

        $this->validate();
//        $path = $this->logo->store('logos');

        $template = EmailTemplate::updateOrCreate(
            ['id' => isset($this->template->id) ? $this->template->id : null],
            [
                'user_id' => Auth::id(),
                'logo' => $this->logo,
                'template_type' => 'Customer',
                'name' => $this->name,
                'subject' => $this->subject,
                'body' => $this->body,
                'parent_id' => $this->parent_id,
                'heading' => $this->heading,
                'paragraph' => $this->paragraph,
                'button_text' => $this->button_text,
                'cta_link' => $this->cta_link,
                'is_active' => $this->is_active,
                'footer' => $this->footer,

            ]
        );

        return redirect()->route('emailTemplate.index')->with('success', true);
    }

    public function updateStatus(){
        $this->is_active =  !$this->is_active;
    }

        public function updateBody(){
        dd('tttt');
        $this->body =  '';
    }


    public function render()
    {
        return view('livewire.mail-template.create-mail-templates');
    }
}
