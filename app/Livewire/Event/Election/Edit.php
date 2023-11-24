<?php

namespace App\Livewire\Event\Election;

use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use Livewire\WithFileUploads;

class Edit extends Component
{

    use WithFileUploads;
    public $steps  = 1;
    public $election_name;
    public $event_id;
    public $event;
    public $election =[];
    public $election_detail;
    public $election_date;
    public $positions = [] ;
    public $pstn_counter = 1;
    public $positionsCltn ;
    public $candidates = [];
    public $candidate = [];
    public $photo;
    public $position = null;
    public $complete = false;


    public function mount(){
        $this->election = $this->election_detail->toArray();
      //  dd($this->election);
        $this->election_date = $this->election['election_date'];
        $this->position = null;
        $this->candidate = [];
        $this->resetValidation();
        $this->positions = ElectivePosition::where('election_id', isset($this->election_detail) ? $this->election_detail->id : null) ->get();

    }

    public function createElection()
    {
        $this->election['election_date'] = Carbon::parse($this->election_date);

        $validatedData = $this->validate([
            'election.name' => 'required|min:2',
            'election.election_date' => 'required|date',
        ]);

        $this->election['event_id'] = $this->event['id'];

        $this->election_detail = Election::updateOrCreate(
            ['id' => isset($this->election_detail) ? $this->election_detail->id : null],
            $this->election
        );
        $this->next();
    }

    public function addElectivePositions(){
        $this->validate([
            'position' => 'required|min:2',
        ]);
        ElectivePosition::create(
            ['position' => $this->position,
                'election_id' => isset($this->election_detail->id) ? $this->election_detail->id : null,
            ]
        );
        $this->mount();
    }
    public function rmvElectivePositions($index){
        ElectivePosition::find($index)->delete();
        $this->mount();
    }


    public function addCandidate(){

        $this->validate([
            'candidate.elective_position_id' => 'required',
            'candidate.name' => 'required|min:2',
            'candidate.member_no' => 'required',
            'candidate.photo' => 'required',
        ]);

        $this->candidate['photo'] = $this->candidate['photo']->store('uploads', 'public');

        CandidateElectivePosition::create(
            $this->candidate
        );
        $this->candidate = [];
        $this->complete = true;
        $this->mount();
    }

    public function rmvCandidate($index){
        CandidateElectivePosition::find($index)->delete();
        $this->mount();
    }

    public function completeForm(){

    }

    public function next(){
        ++$this->steps;
        $this->mount();
    }
    public function prev(){
        --$this->steps;
        $this->mount();
    }


    public function render()
    {
        return view('livewire.event.election.edit');
    }
}
