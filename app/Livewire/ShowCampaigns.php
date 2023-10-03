<?php

namespace App\Livewire;

use App\Models\Campaign;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ShowCampaigns extends Component
{
    public $campaigns;



    public function mount(){
        $this->campaigns = Campaign::orderBy('start_date', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.show-campaigns');
    }


}
