<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\EventMerchandise;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;


use WireUi\Traits\Actions;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;

class EventMerchandises extends Component  implements HasForms, HasTable
{
    use InteractsWithTable, Actions;
    use InteractsWithForms;

    public Event $event;

    public function table(Table $table): Table
    {

        return $table
            ->heading( $this->event->name . ' Merchandise')
            ->modelLabel('Merchandise')
            ->striped()
            ->query(EventMerchandise::query()
                ->where('event_id', $this->event->id)
                ->where('parent_id', null)
                ->orderBy('created_at', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                  TextColumn::make('variants.name')
                    ->label('Variants')
                    ->badge()
                    ->searchable(),
            ])
            ->actions([
                EditAction::make()
                 ->form([
                        TextInput::make('name')
                            ->placeholder('T-Shirt , Mugs')
                            ->required(),
                        Repeater::make('options')
                            ->relationship('variants')
                            ->schema([
                                TextInput::make('name')->label('Variant')->placeholder('XXL, Green')->required(),
                            ])->columns(2)

                    ]),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (EventMerchandise $record) => $record->delete())
            ])
            ->headerActions([
                CreateAction::make('createMerchandise')
                    ->form([
                        TextInput::make('name')
                            ->placeholder('T-Shirt , Mugs')
                            ->required(),
                        Repeater::make('options')
                            ->relationship('variants')
                            ->schema([
                                TextInput::make('name')->label('Variant')->placeholder('XXL, Green')->required(),

                            ])->columns(2)

                    ])
                    ->mutateFormDataUsing(function ( $data): array{
                        $data['event_id'] = $this->event->id;

                        $this->notification()->success(
                            $title = 'Merchandise Added',
                            $description = 'you have successfully added a merchandise to this event'
                        );

                        return $data;
                    }),
            ]);
    }

    public function render()
    {
        return view('livewire.event-merchandises');
    }
}
