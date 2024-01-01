<?php

namespace App\Livewire;

use AfricasTalking\SDK\AfricasTalking;
use App\Models\Election;
use App\Models\Invite;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Livewire\Component;
use App\Models\VerifyVoter as VoterDetails;
use WireUi\Traits\Actions;

class VerifyVoter extends Component
{
    use Actions;

    public $phone_no;
    public $code;

    public Election $election;
    public Invite $voter;


    public function mount()
    {

    }
    public function store()
    {
        $this->validate([
            'phone_no' => ['required',   'regex:/^(0|\+254|254)\d{9}$/'],
        ],
            [ 'regex' => ' Enter a valid Kenyan number',
            ]);
        $username = 'vf567gfgg';
        $apiKey = '200497db36dd9900fe83dd8d82b4e5ecd81a9bb25bb8c58ed8da028bd8979355';

        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();
        $senderId = 'Text40';
        $phoneNumber = $this->phone_no;
        $no = substr($phoneNumber, -9);
        //Check if user has been invited to the Election
        $phoneNumbers = ["+254" . $no, "254" . $no, "0" . $no ];
        $voter = Invite::whereIn('phone_number', $phoneNumbers)
            ->where('event_id', $this->election->event_id)
            ->first();
        if (!$voter){
            $this->notification()->error(
                $title = ' Error ',
                $description = 'Please request the administrator to invite you for the event'
            );
            return false;
        } else {
            $this->voter = $voter;
        }

        //Check if there is  a pending notification
        $pendingVrfctn = VoterDetails::where('phone_no', $no)
            ->where('status', false)
            ->first();

        if ($pendingVrfctn){
            $createdAt = new Carbon($pendingVrfctn->created_at);
            $currentTime = Carbon::now();
            if ($currentTime->diffInMinutes($createdAt) < 2) {
                $this->notification()->error(
                    $title = ' Error ',
                    $description = 'Please wait for 2 minutes before requesting another code'
                );
                return false;
            }
        }

        $new_req = new VoterDetails();
        $new_req->phone_no = $no;
        $new_req->vrfctn_code = $this->vrfctn_code = random_int(1000, 9999);
        $new_req->save();

        $message = "Your election verification code is ". $this->vrfctn_code ;
        /*
                $this->notification()->success(
                        $title = ' Verification Sent Succesfully',
                        $description = $this->vrfctn_code
                    );*/

        try {
            /*$result = $sms->send([
                'to'      => $phoneNumber,
                'message' => $message,
//                'from'    => $senderId,
            ]);*/

            $this->notification()->success(
                $title = ' Verification Sent Succesfully',
                $description = 'Please share the code received via SMS'. $message
            );

        } catch (\Exception $e) {

            $this->notification()->error(
                $title = 'Technical Error',
                $description = $e->getMessage()
            );

        }


    }

    public function submit()
    {
        $this->validate([
            'code' => 'required|min:4'
        ]);

        $phoneNumber = $this->phone_no;
        $no = substr($phoneNumber, -9);
        $pendingVrfctn = VoterDetails::where('phone_no', $no)
            ->where('vrfctn_code', $this->code)
            ->where('status', false)
            ->first();

        //Check if user has been invited to the Election
        $phoneNumbers = ["+254" . $no, "254" . $no, "0" . $no ];
        $voter = Invite::whereIn('phone_number', $phoneNumbers)
            ->where('event_id', $this->election->event_id)
            ->first();

        if ($pendingVrfctn){
            $pendingVrfctn->status = true;
            $pendingVrfctn->save();
            $signedUrl = URL::signedRoute(
                'election.vote.verified', ['election' => $this->election->id, 'vote' => $voter->id]
            );

            return redirect()->to($signedUrl);
        } else {
                        $this->notification()->error(
                $title = 'Please request A new Code',
                $description = "Request new OTP"
            );
        }

    }
    public function render()
    {
        return view('livewire.verify-voter');
    }
}
