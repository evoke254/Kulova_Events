<?php

namespace App\Livewire;

use App\Models\Campaign;
use App\Models\CampaignTemplate;
use App\Models\EmailTemplate;
use App\Models\LandingPage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;
use Livewire\Attributes\On;

class CreateCampaign extends ModalComponent
{
    public $email;
    public $name;
    public $url;
    public $start_date;
    public $end_date;
    public $error;
    public $email_templates;
    public $email_template_id;
    public $campaign_templates = [];
    public $landing_page_id;

    protected $rules = [
        'name' => 'required',
        'email' => 'email',
        //'url' => 'url',
             'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date'
    ];

    #[On('startDateSelected')]
    public function updateStartDate($date = null)
    {
        $this->start_date = $date;
    }
        #[On('endDateSelected')]
    public function updateEndDate($date = null)
    {
        $this->end_date = $date;
    }

    public function mount(){
        $this->campaign_templates = CampaignTemplate::where('user_id', Auth::id())->get()->toArray();
    }


    public function createCampaign(){

        $this->validate();


                $org_id = isset(Auth::user()->organization_id) ? Auth::user()->organization_id : 1;

        try {
             $campaign = Campaign::create(
                    [
                        'name' => $this->name,
                        'organization_id' => $org_id,
                        'email' => $this->email,
                        'user_id' => Auth::id(),
                        'email_template_id' => $this->email_template_id,
                        'start_date' => Carbon::parse($this->start_date),
                        'end_date' => Carbon::parse($this->end_date),

                    ]
                );

             return redirect()->route('campaigns.edit', ['campaign' => $campaign->id])->with('success', true);

        } catch (\Exception $e){
                    $this->error = $e;
                    return false;
        }

    }




}
