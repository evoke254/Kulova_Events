<?php

namespace App\Filament\Imports;

use App\Models\Invite;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class MemberImporter extends Importer
{
    protected static ?string $model = Invite::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('last_name')
                ->requiredMapping()
                ->rules(['max:255']),
            ImportColumn::make('phone_number')
                ->requiredMapping()
                ->rules(['required', 'regex:/^[0-9]{9}$/']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['email']),
        ];
    }

    public function resolveRecord(): ?Invite
    {
         return Invite::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
             'member_no' => $this->data['member_no'],
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
