<?php

namespace App\Livewire\Event;

use App\Filament\Imports\MemberImporter;
use App\Livewire\EventAttendance;
use App\Mail\EventInvitation;
use App\Mail\VoterInvited;
use App\Models\Event;
use App\Models\Invite;
use App\Models\Vote;
use Closure;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Tables\Actions\ImportAction;

use Filament\Tables\Table;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Contracts\HasForms;

use WireUi\Traits\Actions;
use Filament\Tables\Actions\Action;
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
use Illuminate\Contracts\View\View;
use Filament\Forms\Concerns\InteractsWithForms;

class ShowInvites extends Component implements HasForms, HasTable
{
    use InteractsWithTable, Actions;
    use InteractsWithForms;
    public Event $event;
    public $elections;
    public $member_nos;
    public $data;
    public $phone_nos;


    public function mount(){

        $this->member_nos = Invite::where('event_id', $this->event->id)->get()->pluck('member_no')->toArray();
        $this->phone_nos = Invite::where('event_id', $this->event->id)->get()->pluck('phone_number')->toArray();
        $this->elections = $elections = $this->event->elections()->get();
    }


    public function table(Table $table): Table
    {

        return $table
            ->heading('Event Members')
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

                TextColumn::make('registration')
                    ->label('Registered')
                    ->badge()
                    //     ->state(fn (string $state): string => $state === '1' ? 'Yes' : 'No')
                    ->color(fn (string $state): string => match ($state) {
                        'Yes' => 'success',
                        'No' => 'danger',
                    }),
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
                Action::make('attendance')
                    ->url(fn (Invite $record): string => route('attendance.show', ['user' =>$record]))
                    ->openUrlInNewTab(),
                EditAction::make()
                    ->fillForm(fn (Invite $record): array => [
                        'name' => $record->name,
                        'last_name' => $record->last_name,
                        'member_no' => $record->member_no,
                        'email' => $record->email,
                        'details' => $record->details,
                        'phone_number' => substr($record->phone_number, -9),
                    ])
                    ->form([
                        TextInput::make('name')
                            ->label('First Name')
                            ->required(),
                        TextInput::make('last_name')
                            ->required(),
                        TextInput::make('member_no')
                            ->label('Member Number')

                            ->rules([
                                function (Invite $record) {
                                    return function (string $attribute, $value, Closure $fail) use ($record) {
                                        $invite = Invite::where('member_no', $value)
                                            ->where('id', '!=', $record->id)
                                            ->where('event_id', $this->event->id)
                                            ->first();
                                        if ($invite) {
                                            return $fail('The :attribute has already been taken.');
                                        }
                                    };
                                },
                            ])
                            ->minValue(2)
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->prefix('+254')
                            ->placeholder('0702755928')
                            ->required()
                            ->rules([
                                function (Invite $record) {
                                    return function (string $attribute, $value, Closure $fail) use ($record) {
                                        if (!preg_match('/^\d{9}$/', $value)) {
                                            return   $fail('Invalid :attribute format. Example format 702755928.');
                                        } else {
                                            $phoneNumbers = ["+254" . $value, "254" . $value, "0" . $value];
                                            $invite = Invite::whereIn('phone_number', $phoneNumbers)
                                                ->where('id', '!=', $record->id)
                                                ->where('event_id', $this->event->id)
                                                ->first();
                                            if ($invite) {
                                                return $fail('The :attribute has already been taken.');
                                            }
                                        }
                                    };
                                },
                            ]),
                        TextInput::make('email')->required()->email(),
                        Textarea::make('details'),
                    ])
                    ->mutateFormDataUsing(function ( $data): array{
                        if (strlen($data['phone_number']) == 9 && substr($data['phone_number'], 0, 9))
                            $data['phone_number'] = '+254' . $data['phone_number'];
                        return $data;
                    }),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->action(function (Invite $record){
                        Vote::destroy($record->allUserVotes()->get()->pluck('id'));
                        $record->delete();
                    })
            ])
            ->bulkActions([

                BulkAction::make('Event Invitation')
                    ->label('Event Invitation')
                    ->button()
                    ->color('primary')
                    ->requiresConfirmation()
                    ->action(function (array $data, Collection $records): void {

                        foreach ($records as $key => $record){

                            $url = URL::signedRoute('event.registration', ['user' => $record]);
                            $sms = 'Dear '.$record->name.', You have been invited to attend '. $this->event->name .' Kindly click on the link below to register. '. $url;
                            $record->sendSMS($record->phone_number, $sms);

                            if (filter_var($record->email, FILTER_VALIDATE_EMAIL)){
                                Mail::to($record->email)->send(new EventInvitation($record, $url));
                            }
                        }

                        $this->notification()->success(
                            $title = 'Event Invitation Resent',
                            $description = 'We have sent new invitation emails to selected users'
                        );
                        $this->resetTable();
                    }),
                BulkAction::make('Election')
                    ->label('Election Invitation')
                    ->requiresConfirmation()
                    ->hidden(! $this->event->elections()->count())
                    ->action(function (array $data, Collection $records): void {
                        foreach ($records as $key => $record){
                            if (filter_var($record->email, FILTER_VALIDATE_EMAIL)){
                                Mail::to($record->email)->send(new VoterInvited($this->elections, $record));
                            }
                            //invite via SMS and whatsapp
                            $record->electionInvitation($record, $this->elections);
                        }

                        $this->notification()->success(
                            $title = 'Election Resent',
                            $description = 'Selected voters re-invited'
                        );
                        $this->resetTable();
                    })
                ,
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
                            ->minValue(2)
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, Closure $fail) {
                                        $invite = Invite::where('event_id', $this->event->id)->where('member_no', $value)->first();
                                        if ($invite) {
                                            $fail('The :attribute has already been taken.');
                                        }
                                    };
                                },
                            ])
                            ->required(),
                        TextInput::make('phone_number')
                            ->label('Phone Number')
                            ->prefix('+254')
                            ->placeholder('702755928')
                            ->required()
                            ->rules([
                                function () {

                                    return function (string $attribute, $value, Closure $fail) {
                                        if (!preg_match('/^\d{9}$/', $value)) {
                                            return   $fail('Invalid :attribute format. Example format 702755928.');
                                        } else {
                                            $phoneNumbers = ["+254" . $value, "254" . $value, "0" . $value];
                                            $invite = Invite::whereIn('phone_number', $phoneNumbers)
                                                ->where('event_id', $this->event->id)
                                                ->first();
                                            if ($invite) {
                                                return $fail('The :attribute has already been taken.');
                                            }
                                        }
                                    };

                                },
                            ]),
                        TextInput::make('email')->required()->email(),
                        Textarea::make('details'),
                    ])
                    ->mutateFormDataUsing(function ( $data): array{
                        $data['event_id'] = $this->event->id;
                        $data['phone_number'] = '+254' . $data['phone_number'];
                        $data['organization_id'] = $this->event->organization_id;
                        $data['user_id'] = Auth::id();

                        $this->notification()->success(
                            $title = 'Member Added',
                            $description = 'you have successfully invited someone to this event'
                        );

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
