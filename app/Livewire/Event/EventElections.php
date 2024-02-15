<?php

namespace App\Livewire\Event;

use App\Models\Election;
use App\Models\Event;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ViewAction;
use Livewire\Component;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Concerns\InteractsWithForms;

class EventElections extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public Event $event;

    public function mount(){

    }
    public function table(Table $table): Table
    {

        return $table
            ->heading($this->event->name. ' - Elections')
            ->query(Election::query()
                ->where('event_id', $this->event->id)
            //    ->where('organization_id', Auth::user()->organization_id)
                ->orderBy('election_date', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Elections')
                    ->description(fn ( $record)  =>  substr($record->details,0,75 ))
                    ->wrap()
                    ->limit(100)
                    ->searchable(),
                TextColumn::make('elct_type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Candidate Election' => 'success',
                        'Resolution Election' => 'warning',
                    })
                    ->sortable(),
                TextColumn::make('election_date')
                    ->dateTime('D, d M Y H:i')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                /*                SelectFilter::make('tags')
                                    ->label('Recipient Pool')
                                    ->relationship('tags', 'name')
                                    ->multiple()*/
            ])
            ->actions([
                Action::make('Results')
                    ->button()
                    ->color('violet')
                    ->url(fn (Election $record): string => route('election.show', $record)),
  Action::make('Update Details')
                    ->button()
                    ->color('primary')
                    ->url(fn (Election $record): string => route('election.show', $record))
                    ,
                EditAction::make('edit')
                    ->button()
                    ->form([
                        TextInput::make('name')->label('Election')->required(),
                        TextInput::make('venue'),
                        Radio::class::make('type')
                            ->required()
                            ->options(Election::ELECTION_TYPE),
                        Toggle::make('status')->default(true),

                        DateTimePicker::make('election_date')
                            ->minDate(now())
                            ->native(false)
                            ->required(),
                        Textarea::make('details')->label('Description')
                    ]),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Election $record) => $record->delete())
            ])
            ->bulkActions([
        DeleteBulkAction::make()
            ->requiresConfirmation()
            ->action(fn (Event $record) => $record->delete()),
    ])
        ->headerActions([
            CreateAction::make()
                ->form([
                    TextInput::make('name')->label('Election')->required(),
                    TextInput::make('venue'),
                    Radio::class::make('type')
                        ->required()
                        ->options(Election::ELECTION_TYPE),
                    Toggle::make('status')->default(true),

                    DateTimePicker::make('election_date')
                        ->minDate(now())
                        ->native(false)
                        ->required(),
                    Textarea::make('details')->label('Description')
                ])
                ->mutateFormDataUsing(function ( $data): array{
                    $data['event_id'] = $this->event->id;
                    $data['organization_id'] = Auth::user()->organization_id;
                    $data['user_id'] = Auth::id();
                    return $data;
                })
        ]);
    }

    public function styles()
    {
        return [
            'table' => [
                'background-color' => '#your-color',
            ],
        ];
    }
    public function render()
    {
        return view('livewire.event.event-elections');
    }
}
