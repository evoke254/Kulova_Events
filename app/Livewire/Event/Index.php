<?php

namespace App\Livewire\Event;

use App\Models\Event;
use Livewire\Component;

class Index extends Component
{
    public $events;
    public function mount(){
        $this->events = Event::orderBy('created_at', 'DESC')->get();
    }
    public function render()
    {
        return view('livewire.event.index');
    }
}
