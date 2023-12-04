<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Organization;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $files = [];
    public $event = [];

    public $organizations, $categories ;

    public $start_date;
    public $end_date;
    public $category_id;

    protected $rules = [
        'event.name' => 'required',
        'event.venue' => 'required',
        'event.organization_id' => 'required',
        'category_id' => 'required',
        //'url' => 'url',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date'
    ];
    public function mount(){
        $this->categories = EventCategory::orderBy('created_at', 'DESC')->get();
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
        $this->event['event_category_id'] = $this->category_id;

        $event = Event::updateOrCreate(
            ['id' => isset($this->event['id']) ? $this->event['id'] : null],
            $this->event
        );

        foreach ($this->files as $file){
            $path = $file->store('media/uploads', 'public');

            $event->addMedia(storage_path('app/public/'.$path))
                ->withResponsiveImages()
                ->toMediaCollection();
        }

        return redirect()->route('events.show', ['event' => $event])->with('success', true);

    }

    public function _finishUpload($name, $tmpPath, $isMultiple)
    {

        $file = collect($tmpPath)->map(function ($i) {
            return TemporaryUploadedFile::createFromLivewire($i);
        })->toArray();
        $this->dispatch('upload:finished', name: $name, tmpFilenames: collect($file)->map->getFilename()->toArray())->self();

        $file = array_merge($this->getPropertyValue($name), $file);
        app('livewire')->updateProperty($this, $name, $file);
    }

    public function render()
    {
        return view('livewire.event.create');
    }
}
