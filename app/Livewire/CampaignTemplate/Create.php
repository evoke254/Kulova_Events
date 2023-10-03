<?php

namespace App\Livewire\CampaignTemplate;

use App\Models\CampaignTemplate;
use App\Models\EmailTemplate;
use App\Models\LandingPage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Create extends Component
{
    public $campaign_template = [];

    public $tpl;

    public $stepper;

    public $landingPage = [];
    public $parent_id;
    public $title;
    public $body;

    public $emailTpl = [];

    public function mount($campaign_template = null)
    {

        if (isset($campaign_template['id'])){

            if ($campaign_template instanceof CampaignTemplate) {
                $this->campaign_template = $campaign_template->toArray();
                $this->stepper = 1;
            }

            if (isset($campaign_template['page']) ){
                $this->landingPage = is_array($campaign_template['page']) ? $campaign_template['page'] : $campaign_template['page']->toArray();
                //     $this->stepper = 2;
            }else{
                $this->landingPage =  $this->createLandingPage();
            }

        } else {
            $this->campaign_template['is_active'] = true;
            $this->stepper = 0;
        }

        //Set An email template
        if ( $this->stepper == 2  ){
            $tpl = EmailTemplate::where('campaign_template_id', $this->campaign_template['id'])->first();
            if ($tpl){
                $this->emailTpl = $tpl->toArray();
                $this->body = $this->emailTpl['body'];
            }
        }

    }

    public function createTemplate()
    {
        $validatedData = $this->validate([
            'campaign_template.name' => 'required|min:3',
        ],
            [
                'required' => 'A template name is required',
                'min:3' => 'A template name must have a minimum of 3 characters']
        );
        $this->campaign_template['user_id'] = Auth::id();
        $this->campaign_template['permission'] = 'USER';

        $new_template = CampaignTemplate::updateOrCreate(
            ['id' => isset($this->campaign_template['id']) ? $this->campaign_template['id'] : null],
            $this->campaign_template
        );
        $this->campaign_template = $new_template->toArray();
        $this->stepper = 1;
        $this->mount($this->campaign_template);
    }

    public function resetNewComponent()
    {
        $this->mount($this->campaign_template);
    }


    public function createLandingPage() {


        $landingPage = LandingPage::updateOrCreate(
            ['id' => isset($this->emailTpl->id) ? $this->emailTpl->id : null],
            [
                'title' => null,
                'grapes' => null,
                'is_active' => true,
                'campaign_template_id' => $this->campaign_template['id']
            ]
        );
        return $landingPage->toArray();

    }

    public function completelandingPage(LandingPage $landing_page){

        $validatedData = $this->validate([
            'landingPage.title' => 'required|min:3',
        ],
            [
                'required' => 'The page meta title is required',
                'min:3' => 'The meta title must have a minimum of 3 characters']
        );

        $landing_page->title = $this->landingPage['title'];
        $landing_page->save();
        $this->stepper = 2;

        $this->mount($this->campaign_template);
    }


    public function createEmailTpl() {

        if ($this->stepper != 2){
            return false;
        }
        $validatedData = $this->validate([
            'emailTpl.subject' => 'required|min:5',
        ],
            [
                'required' => 'The Email Subject is required',
            ]
        );

        $email_tpl = EmailTemplate::updateOrCreate(
            ['id' => isset($this->emailTpl['id']) ? $this->emailTpl['id'] : null],
            [
                'user_id' => Auth::id(),
                'template_type' => 'CUSTOMER',
                'name' => Str::slug($this->emailTpl['subject']),
                'subject' => $this->emailTpl['subject'],
                'body' => $this->body,
                'campaign_template_id' => $this->campaign_template['id']
            ]
        );
        $this->emailTpl = $email_tpl->toArray();


        return redirect()->route('campaign-template.index')->with('success', true);

    }


    public function stepperStage($step){
        $this->stepper += $step;
    }

    public function render()
    {
        return view('livewire.campaign-template.create');
    }
}
