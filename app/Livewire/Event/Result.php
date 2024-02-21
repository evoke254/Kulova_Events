<?php

namespace App\Livewire\Event;

use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Livewire\Component;
use WireUi\Traits\Actions;
use Filament\Forms\Contracts\HasForms;

class Result extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    use Actions;

    public ?array $data = [];

    public Election $election;
    public $elective_positions;
    public $updating = false;

    public function mount(){
        $electivePstn = $this->elective_positions = $this->election->load('elective_positions')->toArray();
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Election Name : '.$this->election->name)
            ->query( CandidateElectivePosition::where('election_id', $this->election->id) )
            ->defaultGroup(  Group::make('elective_position.position')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible())
            ->columns([
                ImageColumn::make('photo')->circular()->width(100)->height(100),
                TextColumn::make('name')
                    ->label('Candidate')
                    ->searchable(),
                TextColumn::make('votes_count')->label('Votes Count')->sortable(),
                TextColumn::make('percentage_votes')->label('Percentage')->sortable(),

            ])
            ->filters([
                /*                SelectFilter::make('tags')
                                    ->label('Recipient Pool')
                                    ->relationship('tags', 'name')
                                    ->multiple()*/
            ]);
    }
    public function render()
    {
        return view('livewire.event.result');
    }
}
