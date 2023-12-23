<?php

namespace App\Models;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            $model->sendSMS($model->phone_number);
        });
    }

    protected function sendSMS($phoneNumber)
    {
        $username = 'Voke_wa_swiftapps'; // use 'sandbox' for development in the test environment
        $apiKey   = '29412cb64f18704ff64ded618ff9dc900807bc4ef7f96ea487a437d6dcf95f66'; // use your sandbox app API key for development in the test environment
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
