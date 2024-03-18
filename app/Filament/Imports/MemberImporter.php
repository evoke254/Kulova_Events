<?php

namespace App\Filament\Imports;

use App\Models\Invite;
use Closure;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Filament\Forms\Get;

class MemberImporter extends Importer
{
    protected static ?string $model = Invite::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('first_name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->rules(['max:255']),
            ImportColumn::make('phone_number')
                ->rules(['max:255']),
            ImportColumn::make('email')
                ->rules(['required',
                    'email']),
            ImportColumn::make('member_no')
                ->rules(['required','max:255']),

        ];
    }

    public function resolveRecord(): ?Invite
    {
        $this->data['event_id'] = $this->options['event_id'];
        $this->data['organization_id'] = $this->options['organization_id'];
        $this->data['user_id'] = $this->options['user_id'];

        return Invite::firstOrNew( [
            'organization_id' => $this->data['organization_id'],
            'event_id' => $this->data['event_id'],
            'member_no' => $this->data['member_no'],
            'phone_number' => $this->data['phone_number'],
        ]);

    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your member import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
