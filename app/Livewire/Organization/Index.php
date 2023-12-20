<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use Filament\Forms\Components\Repeater;
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

class Index extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public $organizations;

    public function mount()
    {
        $this->organizations = Organization::orderBy('created_at', 'DESC')->get();
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Organization::query()
//                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'DESC') )
            ->columns([
                TextColumn::make('name')
                    ->label('Organization')
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable(),

                TextColumn::make('phone_number')
                    ->label('Phone')
                    ->searchable(),

                TextColumn::make('departments.name')
                    ->label('Departments')
                    ->badge()
                    ->searchable(),
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

                EditAction::make()
                    ->form([
                        TextInput::make('name')->label('Organization Name')->required(),
                        TextInput::make('email')->label('Admin Email')->email(),
                        Textarea::make('description'),
                        Textarea::make('location'),
                        Repeater::make('departments')
                            ->relationship('departments')
                            ->schema([
                                TextInput::make('name')->label('Department')->required(),
                            ])
                    ]),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Organization $record) => $record->delete())
            ])
            ->bulkActions([

                /*BulkAction::make('Assign Pool')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete()),*/
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Organization $record) => $record->delete()),
            ])
            ->headerActions([
                CreateAction::make()
                ->form([
                        TextInput::make('name')->label('Organization Name')->required(),
                        TextInput::make('email')->label('Admin Email')->unique()->email(),
                        Textarea::make('description'),
                        Textarea::make('location'),
                        Repeater::make('departments')
                            ->relationship('departments')
                            ->schema([
                                TextInput::make('name')->label('Department')->required(),
                            ])
                    ])
            ]);
    }


    public function render()
    {
        return view('livewire.organization.index');
    }
}
