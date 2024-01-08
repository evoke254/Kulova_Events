<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventMerchandise;
use App\Models\Invite;
use Closure;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Livewire\Component;
use App\Models\Organization;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use WireUi\Traits\Actions;

class RegisterForEvent extends Component implements HasForms
{
    use InteractsWithForms, Actions;
    public Event $event;
    public Invite$user;
    public $data;
    protected $rules = [
        'data.name' => 'required|min:2',
        'data.attendance_mode' => 'required',
        'data.phone_number' => 'required',
        'data.member_no' => 'required',
    ];
    public $member_nos = [];
    public $phone_nos;
    /**
     * @var mixed[]
     */
    public array $merchandise;

    public function mount(Invite $user): void
    {
        $data = $this->user->toArray();

        //Check Kenyan number
        if (preg_match('/^(?:\+254|254|0)?7\d{8}$/', $data['phone_number'])){
        $data['phone_number'] = substr($data['phone_number'], -9);
        }
        $data['merchandise'] = json_decode($data['merchandise'], true);

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {

        $merchandiseFields = [];
        foreach ($this->event->merchandise()->get() as  $mcds){
            if (!$mcds->parent_id) {
/*                $merchandiseFields[] = TextInput::make('merchandise.' . $mcds->id . '.name')
                    ->label($mcds->name);*/

                $merchandiseFields[] = Select::make('merchandise.' . $mcds->id . '.option')->options($mcds->variants()->get()->pluck('name', 'id')->toArray())
                    ->required()
                    ->label($mcds->name . ' Option');
            }
        }

        return $form
            ->schema([


                TextInput::make('name')
                    ->label('First Name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('member_no')
                    ->label('Member Number')
                    ->minValue(2)
                    ->rules([
                        function () {
                            return function (string $attribute, $value, Closure $fail) {
                                $invite = Invite::where('event_id', $this->event->id)->where('member_no', $value)->where('id', '!=', $this->user->id)->first();
                                if ($invite) {
                                    $fail('The :attribute has already been taken.');
                                }
                            };
                        },
                    ])
                    ->required(),
                TextInput::make('phone_number')
                    ->label('Phone Number')
                    ->prefix('+254')
                    ->placeholder('702755928')
                    ->regex('/^\d{9}$/')
                    ->required()
                    ->rules([
                        function () {
                            return function (string $attribute, $value, Closure $fail) {
                                $phoneNumbers = ["+254" .$value, "254" .$value, "0" .$value ];
                                $invite = Invite::whereIn('phone_number', $phoneNumbers)
                                    ->where('event_id', $this->event->id)
                                    ->where('id', '!=', $this->user->id)
                                    ->first();
                                if ($invite) {
                                    $fail('The :attribute already exists.');
                                }
                            };
                        },
                    ]),
                Radio::make('attendance_mode')
                    ->options([
                        'Physical' => 'Physically',
                        'Virtual' => 'Virtually',
                    ])
                    ->descriptions([
                        'Physical' => 'Present at the venue.',
                        'Virtual' => 'Remote / Online .',
                    ])->required(),
                TextInput::make('email')->disabled(),
                Section::make('Merchandise')
                    ->description('Pick an option')
                    ->schema($merchandiseFields)
            ])->columns(2)
            ->statePath('data')
            ->model($this->user);
    }

    public function create(): void
    {
        $this->validate();
        $this->data = $this->form->getState();
        $this->data['registration_status'] = true;
        $this->user->update($this->data);


        $this->notification()->success(
            $title = 'Registration Details updated',
            $description = 'Your details were successfully updated'
        );

    }
    public function render()
    {
        return view('livewire.register-for-event');
    }
}
