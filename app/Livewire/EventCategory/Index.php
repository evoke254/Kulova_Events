<?php

namespace App\Livewire\EventCategory;

use App\Models\EventCategory;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

    public $categories;

    public function mount(){
        $this->categories = EventCategory::get();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(EventCategory::query()
                //    ->where('user_id', Auth::id())
                ->orderBy('created_at', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Event Categories')
                    ->description(fn ( $record)  =>  $record->description)
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
            ])
            ->filters([
                /*                SelectFilter::make('tags')
                                    ->label('Recipient Pool')
                                    ->relationship('tags', 'name')
                                    ->multiple()*/
            ])
            ->actions([

                EditAction::make('updateAuthor')
                    ->fillForm(fn (EventCategory $record): array => [
                        'name' => $record->name,
                        'description' => $record->description,
                    ])
                    ->form([
                        TextInput::make('name')
                        ->required(),
                        Textarea::make('description'),
                    ])
                    ->action(function (array $data, EventCategory $record): void {
                        $record->update($data);
                    })
                ,
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (EventCategory $record) => $record->delete())
            ])
            ->bulkActions([

                /*BulkAction::make('Assign Pool')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete()),*/
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (EventCategory $record) => $record->delete()),
            ])
            ->emptyStateActions([
                CreateAction::make(),
            ]);
    }

    public function render()
    {
        return view('livewire.event-category.index');
    }
}
