<?php

namespace App\Livewire\Event;

use App\Models\Invite;
use Livewire\Component;

class ShowInvites extends Component
{
    public $invites;


    public function mount($invites){
        if ($invites){
            $this->invites = $invites;
        }
    }
    public function render()
    {
        return view('livewire.event.show-invites');
    }
}
