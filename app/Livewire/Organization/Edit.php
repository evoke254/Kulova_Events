<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
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

class Edit extends Component implements HasForms
{
     use InteractsWithForms, Actions;
    public ?array $data = [];
    public  Organization $organization;

    protected $rules = [
        'organization.name' => 'required|min:2',
    ];

    public function mount(Organization $organization){
        $this->form->fill($organization->toArray());
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
            ->statePath('data')
            ->model($this->organization);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $this->organization->update($data);


        $this->notification()->success(
            $title = 'Organization updated',
            $description = 'Organization details were successfully updated'
        );

        $this->redirect(route('organizations.index'));
    }
    public function render()
    {
        return view('livewire.organization.edit');
    }
}
