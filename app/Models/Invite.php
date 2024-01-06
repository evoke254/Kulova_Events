<?php

namespace App\Models;

use AfricasTalking\SDK\AfricasTalking;
use App\Mail\EventInvitation;
use App\Mail\VoterInvited;
use Barryvdh\Snappy\Facades\SnappyImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        'user_id',
        'ticket'
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
    public function attendance(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            //Create Ticket
            $scanUrl = URL::signedRoute('attend.event', ['user' => $model]);
            $qrCode = QrCode::size(150)->generate($scanUrl);
            $event = Event::find($model->event_id);
            $path = public_path('images/tickets/'. time() . str_shuffle('bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM') . '.png');
            $user = $model;
            SnappyImage::loadView('ticket', compact('user', 'qrCode', 'event'))
                ->setOption('enable-local-file-access', true)
                ->save($path);
            $model->ticket = $path;

            //Send Email invitation
            if (filter_var($model->email, FILTER_VALIDATE_EMAIL)){
                Mail::to($model->email)->send(new EventInvitation($model));
            }

            $elections = Event::find($model->event_id)->elections()->get();
            if (!$elections->isEmpty()){
                $model->electionInvitation($model, $elections);
            }
        });
    }

    public function electionInvitation($model, $elections)
    {

        $pattern = '/^(0|\+254|254)\d{9}$/';
        if (preg_match($pattern, $model->phone_number)) {

            //Whatsapp Message
            $opt = "";
            foreach ($elections as $election) {
                $opt .= $election->name .",\n ";
            }
            $message = "You are invited in the upcoming\n  *" . $opt . "* .\nReply with *Vote* to cast your vote  \n" ;
            $this->sendWhatsapp($model->phone_number, $message);


            $urlencodedtext = urlencode('Hey, Text40 Bot.');
            $url = "https://wa.me/254792782923?text=". $urlencodedtext;
            $message = "You have been invited to vote on WhatsApp \n" . $url;
            $this->sendSMS($model->phone_number, $message);
        }

        if (filter_var($model->email, FILTER_VALIDATE_EMAIL)){
            Mail::to($model->email)->send(new VoterInvited($elections, $model));
        }

    }

    public function sendWhatsapp($to, $message)
    {
        $payload = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => "+254" . substr($to, -9) ,
            "type" => "text",
            "text" => [
                "preview_url" => true,
                "body" => $message
            ]
        ];
        $response = Http::withHeaders([
            'Authorization' => env('waba_admin_token'),
            'Content-Type'=> 'application/json'
        ])->post($this->facebookProfileEndpoint. '203486022842124'.'/messages', $payload);

    }

    protected function sendSMS($phoneNumber, $message)
    {
        $username = 'vf567gfgg';
        $apiKey = '200497db36dd9900fe83dd8d82b4e5ecd81a9bb25bb8c58ed8da028bd8979355';

        $AT       = new AfricasTalking($username, $apiKey);

        $sms      = $AT->sms();
        $result   = $sms->send([
            'to'      => $phoneNumber,
            'message' => $message
        ]);


    }


    public function createTicket()
    {
        $scanUrl = URL::signedRoute('attend.event', ['user' => $this]);
        $qrCode = QrCode::size(150)->generate($scanUrl);
        $event = Event::find($this->event_id);
        $path = public_path('images/tickets/'. time() . str_shuffle('bcdefghijklmnopqrstuvwxyzABCDEFGHIJKLM') . '.png');
        $user = $this;
        SnappyImage::loadView('ticket', compact('user', 'qrCode', 'event'))
            ->setOption('enable-local-file-access', true)
            ->save($path);
        $this->ticket = $path;
        $this->save();
    }

}
