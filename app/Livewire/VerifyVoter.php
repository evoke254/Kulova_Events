<?php

namespace App\Livewire;

use AfricasTalking\SDK\AfricasTalking;
use Livewire\Component;
use App\Models\VerifyVoter as VoterDetails;

class VerifyVoter extends Component
{

    public $phone_no;
    public $sentVrfctnCode = false;


    public function store()
    {
        $this->validate([
            'phone_no' => ['required',   'regex:/^(0|\+254|254)\d{9}$/'],
        ]);
        $username = 'vf567gfgg';
        $apiKey = '200497db36dd9900fe83dd8d82b4e5ecd81a9bb25bb8c58ed8da028bd8979355';

        $AT = new AfricasTalking($username, $apiKey);
        $sms = $AT->sms();
        $senderId = 'Text40';
        $phoneNumber = $this->phone_no;
        $no = substr($phoneNumber, -9);
        $pendingVrfctn = VoterDetails::where('phone_no', $no)
            ->where('status', false)
            ->get();

            $new_req = new VoterDetails();
        $new_req->phone_no = $no;
        $new_req->vrfctn_code = random_int(100000, 999999);
        $new_req->save();
        $this->sentVrfctnCode = true ;

        $message = "Your election verification code is ". $this->vrfctn_code ;



        try {
            // Send the SMS
            $result = $sms->send([
                'to'      => $phoneNumber,
                'message' => $message,
                'from'    => $senderId,
            ]);

            // Log the result or perform other actions if needed
            \Log::info('SMS sent successfully: ' . json_encode($result));

            return response()->json(['message' => 'SMS sent successfully']);
        } catch (\Exception $e) {
            // Handle the exception
            \Log::error('Error sending SMS: ' . $e->getMessage());

            return response()->json(['error' => 'Failed to send SMS'], 500);
        }


    }
    public function render()
    {
        return view('livewire.verify-voter');
    }
}
