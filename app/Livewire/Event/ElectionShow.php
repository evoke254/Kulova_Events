<?php

namespace App\Livewire\Event;

use App\Models\CandidateElectivePosition;
use App\Models\Election;
use App\Models\ElectivePosition;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Actions\CreateAction;
use Livewire\Component;
use WireUi\Traits\Actions;


class ElectionShow extends Component implements HasForms
{
    use InteractsWithForms;
    use Actions;

    public ?array $data = [];

    public Election $election;
    public $elective_positions;
    public $updating = false;

    public function mount(){

        $electivePstn = $this->election->load('elective_positions')->toArray();

        $this->form->fill($electivePstn);
    }


    public function form(Form $form): Form
    {

        if($this->election->type == 1){
            //candidate Elections
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
                                ->default(1),
                            Section::make('Candidates')
                                ->description('Position candidates  ')
                                ->schema([
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
                                        ->columns(3)
                                ])->collapsible()
                                ->columnSpan(2)




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
                            Textarea::make('position')->rows(1)->label('Resolution Question')->required(),
                        ])
                ])
                ->columns(2)
                ->statePath('data');


        }
    }





    public function createPositions()
    {
        $data = $this->form->getState();

        if($this->election->type == 1) {
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

                if (!isset($pstn['candidates']) || empty($pstn['candidates']) ){
                    $pstn['candidates'] = ["Yes", "No"];
                }

                foreach ($pstn['candidates'] as $cdt ){
                    CandidateElectivePosition::updateOrCreate(
                        ['id' => isset($cdt['id']) ? $cdt['id'] : '' ],
                        [
                            'name' =>  $cdt,
                            'photo' =>  'n_a',
                            'member_no' =>  -99,
                            'elective_position_id' =>  $position->id,
                        ]
                    );
                }
            }

        }


        $this->notification()->success(
            $title = ' Election Succesful ',
            $description = 'Your election details were successfully saved'
        );
        $this->mount();
    }


    public function isUpdating()
    {
        $this->updating = !$this->updating;
        $this->mount();
    }

    public function cnfmDelete(ElectivePosition $position)
    {
        $this->dialog()->confirm([
            'title'       => 'Are you Sure. Action cannot be reversed?',
            'description' => 'Delete Position or Resolution with all data associated with it?',
            'icon'        => 'error',
            'reject' => [
                'label'  => 'No, cancel',
            ],
            'accept'      => [
                'label'  => 'Delete',
                'method' => 'DltPosition',
                'params' => $position,
            ],
        ]);
    }

    public function DltPosition(ElectivePosition $position)
    {
        foreach ($position->votes()->get() as $vote){
            $vote->delete();
        }
        foreach ($position->candidates as $cdt){
            $cdt->delete();
        }

        $position->delete();
        $this->mount();
    }
    public function render()
    {
        return view('livewire.event.election-show');
    }
}
