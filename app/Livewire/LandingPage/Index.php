<?php

namespace App\Livewire\LandingPage;

use App\Models\LandingPage;
use Livewire\Component;

class Index extends Component
{

    public $page_templates;
    public $success;

    public function mount(){
        $this->page_templates = LandingPage::orderBy('created_at', 'DESC')->get();
    }

    public function updateStatus(LandingPage $landing_page){
        $landing_page->is_active = !$landing_page->is_active;
        $landing_page->save();
        $this->success = ['Status updated'];
    }

    public function render()
    {
        return view('livewire.landing-page.index');
    }
}
