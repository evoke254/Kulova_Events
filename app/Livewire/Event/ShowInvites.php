<?php

namespace App\Livewire\Event;

use App\Filament\Imports\MemberImporter;
use App\Models\Event;
use App\Models\Invite;
use Filament\Tables\Actions\ImportAction;
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
class ShowInvites extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;
    public Event $event;


    public function mount(){

    }


    public function table(Table $table): Table
    {

        return $table
            ->modelLabel('Member')
            ->striped()
            ->query(Invite::query()
                ->where('event_id', $this->event->id)
                ->orderBy('created_at', 'DESC') )
            //         ->defaultPaginationPageOption(100)
            //         ->paginated([10, 25, 50, 100, 'all'])
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->description(fn(Invite $record) => $record->last_name)
                    ->searchable(),
                TextColumn::make('member_no')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone_number')
                    ->searchable(),
                TextColumn::make('created_by.name')
                    ->label('Created By')
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
            /*            ->filters([
                            SelectFilter::make('recipientPools')
                                ->preload()
                                ->label('Recipient Pool')
                                ->relationship('recipientPools', 'name')
                                ->multiple()
                        ])*/
            ->actions([
                EditAction::make()
                      ->fillForm(fn (Invite $record): array => [
                        'phone_number' => substr($record->name, -9),
                    ])
                    ->form([
                        TextInput::make('name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('member_no')
                            ->label('Member Number')
                            ->unique(ignoreRecord: true)
                            ->minValue(2)
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->placeholder('702755928')
                            ->prefix('+254')
                            ->maxLength(9)
                            ->minValue(1)
                            ->numeric()
                            ->required()
                            ->tel(),
                        TextInput::make('email'),
                        Textarea::make('details'),
                    ])
                    ->mutateFormDataUsing(function ( $data): array{
                        if (strlen($data['phone_number']) == 9 && substr($data['phone_number'], 0, 9))
                        $data['phone_number'] = '+254' . $data['phone_number'];
                        return $data;
                    }),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Invite $record) => $record->delete())
            ])
            ->bulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Invite $record) => $record->delete())
            ])
            ->headerActions([
                CreateAction::make('updateAuthor')
                    ->form([
                        TextInput::make('name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('member_no')
                            ->label('Member Number')
                            ->unique()
                            ->minValue(2)
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->prefix('+254')
                            ->maxLength(9)
                            ->minValue(1)
                            ->numeric()
                            ->required()
                            ->tel(),
                        TextInput::make('email'),
                        Textarea::make('details'),
                    ])
                    ->mutateFormDataUsing(function ( $data): array{
                        $data['event_id'] = $this->event->id;
                        $data['phone_number'] = '+254' . $data['phone_number'];
                        $data['organization_id'] = Auth::user()->organization_id;
                        $data['user_id'] = Auth::id();
                        return $data;
                    }),
/*
                ImportAction::make()->importer(MemberImporter::class)
                    ->mutateFormDataUsing(function ( $data): array{
                        $data['event_id'] = $this->event->id;
                        $data['organization_id'] = Auth::user()->organization_id;
                        $data['user_id'] = Auth::id();
                        return $data;
                    })*/
            ]);
    }





    public function render()
    {
        return view('livewire.event.show-invites');
    }
}
