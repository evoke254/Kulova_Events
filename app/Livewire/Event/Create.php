<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class Create extends Component
{
    public $event = [];

    public $organizations ;

    public $start_date;
    public $end_date;

    protected $rules = [
        'event.name' => 'required',
        'event.venue' => 'required',
        'event.organization_id' => 'required',
        //'url' => 'url',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ];
    public function mount(){
        $this->organizations = Organization::orderBy('created_at', 'DESC')->get();
    }

    #[On('startDateSelected')]
    public function updateStartDate($date = null)
    {
        $this->event['start_date'] = Carbon::parse($date);
    }
    #[On('endDateSelected')]
    public function updateEndDate($date = null){
        $this->event['end_date'] = Carbon::parse($date);
    }
    public function createEvent(){
        $this->validate();

    $this->event['start_date'] = Carbon::parse($this->start_date );
    $this->event['end_date'] = Carbon::parse($this->end_date );
    $this->event['user_id'] = Auth::id();

        $event = Event::updateOrCreate(
            ['id' => isset($this->event['id']) ? $this->event['id'] : null],
            $this->event
        );

        return redirect()->route('events.show', ['event' => $event])->with('success', true);

    }
    public function render()
    {
        return view('livewire.event.create');
    }
}
