<?php

namespace App\Livewire\Profile;

use Livewire\Component;

use Filament\Forms\Components\Select;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\ViewAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Concerns\InteractsWithForms;

class AppUsers extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;

     public function mount()
    {
    }

     public function table(Table $table): Table
    {
        return $table
            ->modelLabel('Application User')
            ->query(\App\Models\User::query()
                ->where('role_id', '<=', 3)
                ->orderBy('created_at', 'DESC') )
            ->columns([
                ImageColumn::make('avatar')->square()->label('photo'),
                TextColumn::make('name')
                    ->description(fn(\App\Models\User $record): string => $record->email)
                    ->searchable(),
                TextColumn::make('RoleName')
                    ->label('Role')
                    ->searchable(),
                TextColumn::make('phone_no')
                    ->searchable(),
                ToggleColumn::make('email_verified_at')->label('Verified')->disabled(),
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
                //
            ])
            ->actions([
                ViewAction::make()
                    ->button()
                    ->color('fuchsia')
                    ->modalContent( fn(\App\Models\User $record): View =>view('profile.app-user', ['user' => $record]) )
                    ->modalHeading('- Profile')
                    ->modalHeading(fn (\App\Models\User $record): string => 'Profile - '. $record->name .'  ( '. $record->email.' )')
                     ->stickyModalHeader()
                    ->modalWidth(MaxWidth::SevenExtraLarge)
                    ->modalAlignment(Alignment::Start),
                EditAction::make()
                    ->button()
                    ->color('gray')
                    ->form([
                        TextInput::make('name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('email')->required()->email(),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),
                        Select::make('role_id')
                            ->required()
                            ->label('Role')
                            ->options([
                                1 => 'Super Admin',
                                2 => 'Admin',
                                3 => 'Support',
                            ]),

                        TextInput::make('commission')->label('Sales Commission %')->required('Phone'),
                        TextInput::make('phone_no')->tel()->label('Phone'),

                        FileUpload::make('avatar')
                            ->label('Photo')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                    ])->using(function (Model $record, array $data): Model {
                        //            dd($data);
                        $record->name = $data['name'];
                        $record->last_name = $data['last_name'];
                        $record->password = $data['password'] ?? $record->password;
                        $record->role_id = $data['role_id'];
                        $record->avatar =  $data['avatar'];
                        $record->email = $data['email'];
                        $record->parent_id = Auth::id();
                        $record->save();
                        return $record;
                    }),
                DeleteAction::make()
                    ->button()
                    ->color('danger')
                    ->requiresConfirmation()
                    ->action(fn (\App\Models\User $record) => $record->delete())
            ])
            ->bulkActions([

                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
            ])
            ->headerActions([
                CreateAction::make()
                    ->color('fuchsia')
                    ->form([
                        TextInput::make('name')->label('First Name')->required(),
                        TextInput::make('last_name')->required(),
                        TextInput::make('email')->required()->email()->unique(),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),
                        Select::make('role_id')
                            ->required()
                            ->label('Role')
                            ->options([
                                1 => 'Super Admin',
                                2 => 'Admin',
                                3 => 'Support',
                            ]),
                        TextInput::make('phone_no')->tel()->label('Phone'),

                        FileUpload::make('avatar')
                            ->label('photo')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                    ])->using(function (array $data): Model {

                        $user = new \App\Models\User();
                        $user->name = $data['name'];
                        $user->last_name = $data['last_name'];
                        $user->password = $data['password'];
                        $user->role_id = $data['role_id'];
                        $user->avatar = $data['avatar'] ?? '';
                        $user->email = $data['email'];
                        $user->save();
                        //   event(new Registered($user));
                        return $user;
                    }),
            ]);
    }


    public function render()
    {
        return view('livewire.profile.app-users');
    }
}
