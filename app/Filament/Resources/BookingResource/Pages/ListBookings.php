<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Filament\Resources\BookingResource\Widgets\StatsOverview;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class
        ];
        
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'pending' => Tab::make()->query(fn ($query)=>$query->where('status', 'pending')),
            'approved' => Tab::make()->query(fn ($query)=>$query->where('status', 'approved')),
            'rejected' => Tab::make()->query(fn ($query)=>$query->where('status', 'rejected')),
            'return' => Tab::make()->query(fn ($query)=>$query->where('status', 'return')),
        ];
    }
}
