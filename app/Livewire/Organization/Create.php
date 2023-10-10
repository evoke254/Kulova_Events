<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Livewire\Component;

class Create extends Component
{
    public $organization = [];

    protected $rules = [
        'organization.name' => 'required|min:2',
    ];


    public function mount($org = null){
        if ($org){
            $this->organization = $org->toArray();
        }
    }
    public function createOrganization(){
        $this->validate();
        $org = Organization::updateOrCreate(
            ['id' => isset($this->organization['id']) ? $this->organization['id'] : null],
            $this->organization
        );

        return redirect()->route('organizations.index')->with('success', true);
    }
    public function render()
    {
        return view('livewire.organization.create');
    }
}
