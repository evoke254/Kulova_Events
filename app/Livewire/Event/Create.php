<?php

namespace App\Livewire\Event;

use App\Models\Event;
use App\Models\EventImage;
use App\Models\Organization;
use App\Models\User;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class Create extends Component   implements HasForms
{
    use InteractsWithForms, WithFileUploads, Actions;
    public ?array $data = [];
    public function mount(): void
    {
        $this->form->fill();
        $this->event = new Event();
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

    public function form(Form $form): Form
    {
        if (Auth::user()->role_id > 3){
            $orgs =   Organization::query()->where('id', Auth::user()->organization_id)->pluck('name', 'id');
        } else {
            $orgs =   \App\Models\Organization::query()->pluck('name', 'id');
        }
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Select::make('organization_id')
                    ->required()
                    ->label('Organization')
                    ->options($orgs),
                TextInput::make('venue')
                    ->required(),
                TextInput::make('cost')
                    ->numeric()

                    ->prefixIcon('heroicon-m-currency-dollar')
                    ->minValue(0)
                    ->required(),
                DateTimePicker::make('start_date')
                    ->native(false)
                    ->required(),
                DateTimePicker::make('end_date')
                    ->native(false)
                    ->required(),

                Select::make('categories')
                    ->multiple()
                    ->label('Event Category')
                    ->options(\App\Models\EventCategory::query()->pluck('name', 'id')),

                RichEditor::make('description')
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ]),

                FileUpload::make('images.image')
                    ->disk('public')
                    ->required()
                    ->multiple()
                    ->columnSpanFull()
                    ->reorderable()
                    ->imageEditor()
                    ->columnSpan(1),


                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(true)
                    ->columnSpan(1),



            ])->columns(2)
            ->statePath('data');
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $data['user_id'] = Auth::id();

        $event = Event::create($data);
        foreach ($data['images']  as $files){
            /*            $event->addMedia(storage_path('app/public/'.$file))
                            ->withResponsiveImages()
                            ->toMediaCollection();*/
            foreach ($files as $file){
                EventImage::create(['event_id' => $event->id, 'image' => $file]);
            }
        }
        $event->attachTags($data['categories']);
        $this->notification()->success(
            $title = 'Event saved',
            $description = 'Event details were successfully saved'
        );

        $this->redirect(route('events.index'));

    }

    public function render()
    {
        return view('livewire.event.create');
    }
}
