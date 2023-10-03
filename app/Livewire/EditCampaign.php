<?php

namespace App\Livewire;

use Livewire\Component;

class EditCampaign extends Component
{

    public $success;

    public function mount($success = null){
        $this->success = $success;
    }
    public function render()
    {
        return view('livewire.edit-campaign');
    }
}
