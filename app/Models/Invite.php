<?php

namespace App\Models;

use AfricasTalking\SDK\AfricasTalking;
use App\Mail\VoterInvited;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class Invite extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'name',
        'last_name',
        'phone_number',
        'email',
        'member_no',
        'details',
        'organization_id',
        'user_id'
    ];

    protected $facebookProfileEndpoint = 'https://graph.facebook.com/v18.0/';

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function allUserVotes(): HasMany
    {
        return $this->HasMany(Vote::class);
    }


    public function castVotes($elective_position_id , $candidate_elective_position_id)
    {
        return Vote::where('elective_position_id',  $elective_position_id)
            ->where('candidate_elective_position_id', $candidate_elective_position_id)
            ->where('invite_id', $this->id)
            ->get();
    }

    //Checks whether user can cast vote in a position
    public function castVoteInPstn($elective_position_id) :bool
    {
        $allowed_votes = ElectivePosition::find($elective_position_id)->votes;

        $votes = Vote::where('elective_position_id',  $elective_position_id)
            ->where('invite_id', $this->id)
            ->get()
            ->count();
        return($allowed_votes > $votes);

    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->electionInvitation($model);
        });
    }

    public function electionInvitation($model)
    {
        $event = Event::find($model->event_id)->first();
        $elections = Event::find($model->event_id)->elections()->get();
        foreach ($elections as $elctn){
            $pattern = '/^(0|\+254|254)\d{9}$/';
            if (preg_match($pattern, $model->phone_number)) {
                $this->sendWhatsapp($model->phone_number, $elctn);
                //$this->sendSMS($model->phone_number);
            }
            if (filter_var($model->email, FILTER_VALIDATE_EMAIL)){
                Mail::to($model->email)->send(new VoterInvited($elctn, $model));
            }

        }

        //           $model->sendSMS($model->phone_number);
    }

    public function sendWhatsapp($to, $election)
    {
        $body = "You are invited in the upcoming  *" . $election->name . "* .\nReply with *Vote* to cast your vote  \n" ;
        $payload = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "+254" . substr($to, -9) ,
            "type" => "text",
            "text" => [
                "preview_url" => true,
                "body" => $body
            ]
        ];
        $response = Http::withHeaders([
            'Authorization' => env('waba_admin_token'),
            'Content-Type'=> 'application/json'
        ])->post($this->facebookProfileEndpoint. '203486022842124'.'/messages', $payload);

    }

    protected function sendSMS($phoneNumber)
    {
        $username = 'vf567gfgg';
        $apiKey = '200497db36dd9900fe83dd8d82b4e5ecd81a9bb25bb8c58ed8da028bd8979355';

        $AT       = new AfricasTalking($username, $apiKey);
        if (preg_match('/^(?:\+254|254|0)(7\d{8})$/', $phoneNumber)) {
            $sms      = $AT->sms();
            /*$result   = $sms->send([
                'to'      => $phoneNumber,
                'message' => "You have been invited to attend\nSwift Apps Africa "
            ]);*/
        }

    }



}
