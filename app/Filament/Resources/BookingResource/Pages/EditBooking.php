<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Mail\StatusChangedNotification;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class EditBooking extends EditRecord
{
    protected static string $resource = BookingResource::class;

    protected function afterSave(): void
    {
        $record = $this->record; // Access the created record
        if ($record->status !== 'pending') {
            Mail::to($record->email)->send(new StatusChangedNotification($record));
        }
            
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
