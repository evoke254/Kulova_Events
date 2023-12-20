<?php

namespace App\Livewire\Event;

use App\Models\Election;
use App\Models\Event;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use Livewire\Attributes\Reactive;
use Livewire\Component;
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
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Filament\Forms\Concerns\InteractsWithForms;

class ElectionIndex extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public Event$event;

    public function mount(){
//
    }

    public function table(Table $table): Table
    {

        return $table
            ->query(Election::query()
                ->orderBy('election_date', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Elections')
                    ->description(fn ( $record)  =>  substr($record->details,0,30 ))
                    ->wrap()
                    ->limit(100)
                    ->searchable(),
                TextColumn::make('event.name')
                    ->badge()
                    ->url(fn (Election $record): string => route('events.show', $record->event->id))
                    ->searchable(),
                TextColumn::make('organization.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('elct_type')
                    ->label('Type')
                    ->color(fn (string $state): string => match ($state) {
                        'Candidate Election' => 'success',
                        'Resolution Election' => 'warning',
                    })
                    ->sortable(),
                ToggleColumn::make('status')
                    ->sortable(),
                TextColumn::make('election_date')
                    ->dateTime()
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

                ViewAction::make('show')
                    ->url(fn (Election $record): string => route('election.show', $record)),
                EditAction::make('edit')
                    ->url(fn (Election $record): string => route('election.edit', $record)),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Election $record) => $record->delete())
            ])
            ->bulkActions([

                /*BulkAction::make('Assign Pool')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete()),*/
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Event $record) => $record->delete()),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public function render()
    {
        return view('livewire.event.election-index');
    }
}
