<?php

namespace App\Livewire\CampaignTemplate;

use App\Models\CampaignTemplate;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Index extends Component
{
    public $campaign_templates;



    public function mount($campaign_template = null){
        $this->campaign_templates = CampaignTemplate::orderBy('created_at', 'DESC')->get();
    }

    public function updateStatus(CampaignTemplate $campaign_template){
        $campaign_template->is_active = !$campaign_template->is_active;
        $campaign_template->save();
    }



    public function render()
    {
        return view('livewire.campaign-template.index');
    }
}
