<?php

namespace App\Livewire\Event\Election;

use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use Carbon\Carbon;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class Create extends Component
{
    use WithFileUploads, Actions;
    public $steps  = 0;
    public $election_name;
    public $election_date;
    public $electionTypes = [1 => 'Single Vote', 2 => 'Plural Vote', 3 =>'Resolution Vote'], $electionType;

    public $event_id;
    public $event;
    public $election =[];
    public $election_detail;
    public $positions = [] ;
    public $pstn_counter = 1;
    public $positionsCltn ;
    public $candidates = [];
    public $candidate = [];
    public $photo;
    public $position = null;
    public $positionVotes = 1;
    public $complete = false;


    public function mount(){
        $this->position = null;
        $this->candidate = [];
        $this->resetValidation();
        $this->positions = ElectivePosition::where('election_id', isset($this->election_detail) ? $this->election_detail->id : null) ->get();

    }

    #[On('electionDateSelected')]
    public function updateElectionDate($date = null)
    {

    }

    public function createElection()
    {
        $this->election['election_date'] = Carbon::parse($this->election_date);
        $validatedData = $this->validate([
            'election.name' => 'required|min:2',
            'election.election_date' => 'required|date',
        ]);

        $this->election['event_id'] = $this->event['id'];
        $this->election['type'] = $this->electionType;

        $this->election_detail = Election::updateOrCreate(
            ['id' => isset($this->election_detail) ? $this->election_detail->id : null],
            $this->election
        );
        $this->next();
    }

    public function addElectivePositions(){
        $this->validate([
            'position' => 'required|min:2',
        ], ['position.required' => 'Kindly fill in a title or Resolution']);

        ElectivePosition::create(
            ['position' => $this->position,
                'votes' => $this->positionVotes,
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


    public function submitResolutions(){
        $this->notification()->success(
            $title = 'Resolution Election Submitted',
            $description = 'Your election was successfully saved'
        );
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

    public function setElectionType($type){

        $this->mount();
    }

    public function stepTwo(){
        $this->validate([ 'electionType' => 'required']);
        $this->next();
    }

    public function render()
    {
        return view('livewire.event.election.create');
    }
}
