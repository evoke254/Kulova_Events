<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use WireUi\Traits\Actions;

class Create extends Component implements HasForms
{
    use InteractsWithForms, Actions;
    public ?array $data = [];
    public  Organization $organization;

    protected $rules = [
        'organization.name' => 'required|min:2',
    ];

    public function mount(){
        $this->form->fill();
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email(),
                Textarea::make('description'),
                Textarea::make('location'),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $org = Organization::create($data);

        $this->notification()->success(
            $title = 'Organization saved',
            $description = 'Organization details were successfully saved'
        );


    }
    public function render()
    {
        return view('livewire.organization.create');
    }
}
