<?php

namespace App\Livewire\Profile;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
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
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Forms\Concerns\InteractsWithForms;
class User extends Component implements HasForms, HasTable, HasActions
{
    use InteractsWithTable;
    use InteractsWithForms;
    use InteractsWithActions;
    public $emails;

    public $user, $organization;
    public function mount(){
        if (!$this->user){
            $this->user = Auth::user();
        }
     //   dd($this->organization);
    }





    public function table(Table $table): Table
    {

        return $table
            ->modelLabel('Admin User')
            ->query(\App\Models\User::query()
                ->where('organization_id', $this->organization->id)
                ->orderBy('created_at', 'DESC') )
            ->columns([
                ImageColumn::make('avatar')->rounded()->label('photo'),

                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('name')
                    ->description(fn(\App\Models\User $record): string => $record->email)
                    ->searchable(),
                TextColumn::make('phone_no')
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
                //
            ])
            ->actions([

                EditAction::make()
                    ->form([
                        TextInput::make('name')->required(),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),

                        TextInput::make('email')->required()->email(),
                        TextInput::make('title')->placeholder('Data Engineer'),
                        TextInput::make('phone_no')->tel()->label('Phone'),

                        FileUpload::make('avatar')
                            ->label('Photo')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                    ])->using(function (Model $record, array $data): Model {
                        //            dd($data);
                        $record->name = $data['name'];
                        $record->password = $data['password'] ?? $record->password;

                        $record->avatar =  $data['avatar'];

                        $record->title = $data['title'] ?? '';
                        $record->email = $data['email'];
                        $record->phone_no = $data['phone_no'];
                        $record->parent_id = Auth::id();
                        $record->save();
                        return $record;
                    }),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(fn (\App\Models\User $record) => $record->delete())
            ])
/*            ->bulkActions([
                DeleteBulkAction::make()
                    ->requiresConfirmation()
                    ->action(fn (\App\Models\User $record) => $record->delete())
            ])*/
            ->emptyStateActions([
                CreateAction::make()
                    ->form([
                        TextInput::make('name')->required(),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),

                        TextInput::make('email')->required()->email()->unique(),
                        TextInput::make('title')->placeholder('Data Engineer'),
                        TextInput::make('phone_no')->tel()->label('Phone'),

                        FileUpload::make('avater')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                    ])->using(function (array $data): Model {

                        $user = new \App\Models\User();
                        $user->name = $data['name'];
                        $user->password = $data['password'];
                        $user->avatar = $data['avatar'] ?? '';
                        $user->title = $data['title'] ?? '';
                        $user->email = $data['email'];
                        $user->phone_no = $data['phone_no'];
                        $user->parent_id = Auth::id();
                        $user->save();
                        event(new Registered($user));
                        return $user;
                    }),
            ]) ->headerActions([
                CreateAction::make()
                    ->form([
                        TextInput::make('name')->required(),
                        TextInput::make('password')
                            ->required()
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state)),

                        TextInput::make('email')->required()->email()->unique(),
                        TextInput::make('title')->placeholder('Data Engineer'),
                        TextInput::make('phone_no')->tel()->label('Phone'),

                        FileUpload::make('avatar')
                            ->disk('public')
                            ->image()
                            ->imageEditor(),

                    ])->using(function (array $data): Model {

                        $user = new \App\Models\User();
                        $user->name = $data['name'];
                        $user->password = $data['password'];
                        $user->avatar = $data['avatar'] ?? '';
                        $user->title = $data['title'] ?? '';
                        $user->email = $data['email'];
                        $user->parent_id = Auth::id();
                        $user->save();
                        event(new Registered($user));
                        return $user;
                    }),
            ]);
    }


    public function createAction(): Action
    {
        return Action::make('sw')
            ->form([
                TextInput::make('name')->required(),
                TextInput::make('password')
                    ->required()
                    ->password()
                            ->revealable()
                    ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                    ->dehydrated(fn ($state) => filled($state)),

                TextInput::make('email')->required()->email()->unique(),
                TextInput::make('title')->placeholder('Data Engineer'),
                TextInput::make('phone_no')->tel()->label('Phone'),

                FileUpload::make('avatar')
                    ->disk('public')
                    ->image()
                    ->imageEditor(),

            ])->action(function (array $data): Model {

                $user = new \App\Models\User();
                $user->name = $data['name'];
                $user->password = $data['password'];
                $user->avatar = $data['avatar'] ?? '';
                $user->title = $data['title'] ?? '';
                $user->email = $data['email'];
                $user->parent_id = Auth::id();
                $user->save();
                return $user;
            });


    }

    public function render()
    {
        return view('livewire.profile.user');
    }


}
