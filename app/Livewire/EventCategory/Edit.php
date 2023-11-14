<?php

namespace App\Livewire\EventCategory;

use App\Models\EventCategory;
use Livewire\Component;
use WireUi\Traits\Actions;

class Edit extends Component
{
        use Actions;
    public $event_category;

    protected $rules = [
        'event_category.name' => 'required|min:2'
    ];

    public function mount(){

    }
    public function save(){
        $this->validate();
        EventCategory::updateOrCreate(
            ['id' => isset($this->event_category['id']) ? $this->event_category['id'] : null],
            $this->event_category
        );

        $this->notification()->success(
            $title = 'Success',
            $description = 'Category successfully saved'
        );
        return redirect()->route('event-category.index');
    }
    public function render()
    {
        return view('livewire.event-category.edit');
    }
}
