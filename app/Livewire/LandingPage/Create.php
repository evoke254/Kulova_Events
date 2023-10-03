<?php

namespace App\Livewire\LandingPage;

use App\Models\LandingPage;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
    public $error;
    public $landingPage;
    public $parent_id;
    public $body;
    public $subject;
    public $is_active;

    public $user_id;
    public $title;
    public $name;

    protected $rules = [
        'name' => 'required|min:2',
        'title' => 'required|min:2',
        'body' => 'required|min:2',
    ];
    public function mount($landingPage = null){

        $this->landingPage  = $landingPage;
        $this->is_active = true;
        if ($this->landingPage){
            $this->name = $this->landingPage->name;
            $this->user_id = $this->landingPage->user_id;
            $this->title = $this->landingPage->title;
            $this->body = $this->landingPage->body;
            $this->is_active = $this->landingPage->is_active;
            $this->parent_id = $this->landingPage->parent_id;
        }

    }


    public function createTemplate() {

        $this->validate();
//        $path = $this->logo->store('logos');

        $landingPage = LandingPage::updateOrCreate(
            ['id' => isset($this->landingPage->id) ? $this->landingPage->id : null],
            [
                'user_id' => Auth::id(),
                'template_type' => 'Customer',
                'name' => $this->name,
                'title' => $this->title,
                'body' => $this->body,
                'is_active' => $this->is_active,

            ]
        );

        return redirect()->route('landing-page.edit', ['landing_page' => $landingPage->id])->with('success', true);
    }

    public function render()
    {
        return view('livewire.landing-page.create');
    }
}
