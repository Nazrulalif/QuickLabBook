<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Mail\StatusChangedNotification;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;

    protected function afterValidate(): void
    {
        $record = $this->record; // Access the created record
        if ($record->status !== 'pending') {
            Mail::to($record->email)->send(new StatusChangedNotification($record));
        }
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
