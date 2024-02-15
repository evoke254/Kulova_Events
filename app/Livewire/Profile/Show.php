<?php

namespace App\Livewire\Profile;

use App\Models\Organization;
use App\Models\User;
use Livewire\Component;

class Show extends Component
{
    public Organization $organization;
    public $user;

    public function mount()
    {
        $this->user = User::find($this->organization->user_id);

    }
    public function render()
    {
        return view('livewire.profile.show');
    }
}
