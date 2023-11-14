<?php

namespace App\Livewire\EventCategory;

use App\Models\EventCategory;
use Livewire\Component;

class Index extends Component
{
    public $categories;

    public function mount(){
        $this->categories = EventCategory::get();
    }
    public function render()
    {
        return view('livewire.event-category.index');
    }
}
