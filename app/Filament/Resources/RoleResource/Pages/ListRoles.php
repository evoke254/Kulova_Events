<?php declare(strict_types=1);

namespace App\Filament\RoleResource\Pages;

use Chiiya\FilamentAccessControl\Resources\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRoles extends ListRecords
{
    public static function getResource(): string
    {
        return config('filament-access-control.resources.role', RoleResource::class);
    }

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
