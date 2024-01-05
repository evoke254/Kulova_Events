<?php

namespace App\Livewire;

use App\Models\Invite;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use Filament\Forms\Concerns\InteractsWithForms;
class EventAttendance extends Component  implements HasForms, HasTable
{
    use InteractsWithTable, Actions;
    use InteractsWithForms;
    public Invite $invite;


        public function table(Table $table): Table
        {

            return $table
                ->modelLabel('Member')
                ->striped()
                            ->query(Invite::query()
                ->where('event_id', $this->event->id)
                ->orderBy('created_at', 'DESC') )
            ->columns([
                ]);
            }
    public function render()
    {
        return view('livewire.event-attendance');
    }
}
