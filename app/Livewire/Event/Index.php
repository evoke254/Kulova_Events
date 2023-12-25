<?php

namespace App\Livewire\Event;

use App\Models\Event;


use App\Models\EventCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
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

class Index extends Component  implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public $events;
    public function mount(){
        $this->events = Event::orderBy('created_at', 'DESC')->get();
    }

        public function table(Table $table): Table
    {
        return $table
            ->query(Event::query()
            //    ->where('organization_id', Auth::user()->organization_id)
                ->orderBy('start_date', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Events')
                    ->description(fn ( $record)  =>  substr($record->venue,0,30 ))
                    ->wrap()
                    ->limit(100)
                    ->searchable(),
                ImageColumn::make('images.image')->label('Image')->width(75)->height(75)->rounded()->limit(2)->stacked(),
                TextColumn::make('organization.name')
                    ->sortable()
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->sortable(),
                  TextColumn::make('categories.name')
                    ->label('Categories')
                    ->badge()
                      ->listWithLineBreaks()
                    ->searchable(),
                ToggleColumn::make('is_featured')
                    ->sortable(),

                TextColumn::make('start_date')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('end_date')
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
                    ->url(fn (Event $record): string => route('events.show', $record)),
                EditAction::make('edit')
                    ->url(fn (Event $record): string => route('events.edit', $record)),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Event $record) => $record->delete())
            ])
            ->bulkActions([

                /*BulkAction::make('Assign Pool')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete()),*/
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Event $record) => $record->delete()),
            ]);
    }

    public function render()
    {
        return view('livewire.event.index');
    }
}
