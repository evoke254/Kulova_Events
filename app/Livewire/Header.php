<?php

namespace App\Livewire;

use Livewire\Component;

class Header extends Component
{
    public $showMobile = false;

    public function toggleMobile(){
        $this->showMobile = !$this->showMobile;
    }

    public function render()
    {
        return view('livewire.header');
    }
}
