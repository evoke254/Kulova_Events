<?php

namespace App\Livewire\Event;

use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Livewire\Component;

use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use WireUi\Traits\Actions;

class ElectionShow extends Component implements HasForms
{
    use InteractsWithForms, Actions;
    public ?array $data = [];

    public Election $election;
    public $elective_positions;
    public $updating = true;

    public function mount(){

        $electivePstn = $this->election->load('elective_positions')->toArray();

        //  $electivePstn =$this->election->toArray();

        $this->form->fill($electivePstn);
    }

    //Adds an array of elective positions or resolutions
    public function addCandidates(Form $form): Form
    {
        return $form
            ->schema([

            ])
            ->statePath('data');
    }

    public function form(Form $form): Form
    {

        if($this->election->type != 3){
            return $form
                ->schema([
                    Repeater::make('elective_positions')
                        ->schema([
                            TextInput::make('position')->label('Position Title')
                                ->columnSpan(1)
                                ->required(),
                            TextInput::make('votes')
                                ->label('No. of votes')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(($this->election->type == 2) ? 100 : 1  )
                                ->default(1),

                            Repeater::make('candidates')
                                ->schema([
                                    FileUpload::make('photo')
                                        ->disk('public')
                                        ->image()
                                        ->required()
                                        ->imageEditor(),
                                    TextInput::make('name')->label('Candidate Name')
                                        ->required(),
                                    TextInput::make('member_no')
                                        ->label('Member No.')
                                        ->required()
                                        ->numeric(),
                                ])
                                ->columnSpan(2)
                                ->columns(3)




                        ])->columns(4)
                ])
                ->statePath('data');
        }
        else {


            return $form
                ->schema([
                    Repeater::make('elective_positions')
                        ->label('Resolutions')
                        ->schema([
                            Textarea::make('position')->label('Resolution')->required()->rows(3),
                            Repeater::make('candidates')
                                ->label('Resolution Options')
                                ->schema([
                                    TextInput::make('name')->label('Option')
                                        ->required(),
                                ])

                        ])->columns(2)
                ])
                ->statePath('data');


        }
    }

    public function createPositions()
    {
        $data = $this->form->getState();

        if($this->election->type != 3) {
            foreach ($data['elective_positions'] as $pstn) {
                $position = ElectivePosition::updateOrCreate(
                    ['id' => isset($pstn['id']) ? $pstn['id'] : ' ' ],
                    [
                        'position' =>  $pstn['position'],
                        'votes' =>  $pstn['votes'],
                        'election_id' =>  $this->election->id,
                    ]
                );

                foreach ($pstn['candidates'] as $cdt ){
                    CandidateElectivePosition::updateOrCreate(
                        ['id' => isset($cdt['id']) ? $cdt['id'] : '' ],
                        [
                            'name' =>  $cdt['name'],
                            'photo' =>  $cdt['photo'],
                            'member_no' =>  $cdt['member_no'],
                            'elective_position_id' =>  $position->id,
                        ]
                    );
                }
            }
        } else {
            //Update resolutions

            foreach ($data['elective_positions']  as $pstn) {
                $position = ElectivePosition::updateOrCreate(
                    ['id' => isset($pstn['id']) ? $pstn['id'] : '' ],
                    [
                        'position' =>  $pstn['position'],
                        'votes' =>  1,
                        'election_id' =>  $this->election->id,
                    ]
                );

                foreach ($pstn['candidates'] as $cdt ){
                    CandidateElectivePosition::updateOrCreate(
                        ['id' => isset($cdt['id']) ? $cdt['id'] : '' ],
                        [
                            'name' =>  $cdt['name'],
                            'photo' =>  'n_a',
                            'member_no' =>  -99,
                            'elective_position_id' =>  $position->id,
                        ]
                    );
                }
            }

        }


        $this->notification()->success(
            $title = ' Election Created ',
            $description = 'Your election was successfully saved'
        );

    }


    public function isUpdating()
    {
        $this->updating = !$this->updating;
    }
    public function render()
    {
        return view('livewire.event.election-show');
    }
}
