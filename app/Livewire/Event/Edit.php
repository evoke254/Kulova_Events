<?php

namespace App\Livewire\Event;

use App\Models\EventCategory;
use App\Models\EventImage;
use Filament\Forms\Components\MorphToSelect;
use Filament\Forms\Components\RichEditor;
use Livewire\Component;
use App\Models\Event;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
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
use Livewire\WithFileUploads;
use Spatie\Tags\Tag;
use WireUi\Traits\Actions;

class Edit extends Component   implements HasForms
{
    use InteractsWithForms, WithFileUploads, Actions;
    public ?array $data = [];
    public Event $event;
    public function mount(Event $event): void
    {
        $this->event = $event;
        $data = $event->toArray();
        $data['categories'] = $event->tags->pluck('id')->toArray();
        $data['uploads'] = $event->images->pluck('image')->toArray();


        //   dd($data);
        //$data['images'] =
        //   dd($event->getMedia());
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Select::make('organization_id')
                    ->required()
                    ->label('Organization')
                    ->options(\App\Models\Organization::query()->pluck('name', 'id')),
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

                Toggle::make('is_featured')
                    ->label('Featured')
                    ->default(true)
                    ->columnSpan(1),

                Select::make('categories')
                    ->multiple()
                    ->label('Event Category')
                    ->options(\App\Models\EventCategory::query()->pluck('name', 'id')),

                Repeater::make('speakers')
                    ->relationship()
                    ->schema([
                        TextInput::make('speaker')->required(),
                        Textarea::make('topic'),
                        FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->image()
                            ->required()
                            ->columnSpan(1)
                            ->imageEditor(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

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

                FileUpload::make('uploads')
                    ->label('Event Images')
                    ->disk('public')
                    ->image()
                    ->required()
                    ->columnSpan(1)
                    ->multiple()
                    ->imageEditor(),


                Repeater::make('agendas')
                    ->label('Agenda')
                    ->relationship()
                    ->schema([
                        TextInput::make('name')->required(),
                        Textarea::make('description'),
                    ])
                    ->columns(2),


                Repeater::make('exhibitors')
                    ->relationship()
                    ->schema([
                        TextInput::make('exhibitor')->required(),
                        Textarea::make('topic'),
                        FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->image()
                            ->required()
                            ->columnSpan(1)
                            ->imageEditor(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),
                Repeater::make('sponsors')
                    ->relationship()
                    ->schema([
                        TextInput::make('sponsor')->required(),
                        Textarea::make('topic')->label('details'),
                        FileUpload::make('image')
                            ->label('Image')
                            ->disk('public')
                            ->image()
                            ->required()
                            ->columnSpan(1)
                            ->imageEditor(),
                    ])
                    ->columns(3)
                    ->columnSpanFull(),

            ])->columns(2)
            ->statePath('data')
            ->model($this->event);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        $this->event->update($data);

        foreach ($data['uploads']  as $file){
            if ( EventImage::where('image', $file)->get()->empty()) {
                EventImage::updateOrCreate(
                    ['event_id' => $this->event->id, 'image' => $file],
                    ['event_id' => $this->event->id, 'image' => $file]);
            }

        }
        $this->event->syncTags($data['categories']);
        $this->notification()->success(
            $title = 'Event updated',
            $description = 'Event details were successfully updated'
        );

        $this->redirect(route('events.show', ['event' => $this->event]));

    }

    public function render()
    {
        return view('livewire.event.edit');
    }
}
