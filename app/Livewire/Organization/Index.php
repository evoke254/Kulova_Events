<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class Index extends Component
{
    public $organizations;

    public function mount(){
        $this->organizations = Organization::orderBy('created_at', 'DESC')->get();
    }
    public function render()
    {
        return view('livewire.organization.index');
    }
}
