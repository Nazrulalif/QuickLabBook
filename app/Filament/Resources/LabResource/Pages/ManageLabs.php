<?php

namespace App\Filament\Resources\LabResource\Pages;

use App\Filament\Resources\LabResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLabs extends ManageRecords
{
    protected static string $resource = LabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
