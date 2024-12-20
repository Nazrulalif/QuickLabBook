<?php

namespace App\Filament\Resources\BookingResource\Widgets;

use App\Models\Booking;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    
    protected function getStats(): array
    {
        return [
            Stat::make('Total Booking', Booking::all()->count()),
            Stat::make('Current Pending', Booking::query()->where('status', 'pending')->count()),
            Stat::make('Total Approve', Booking::query()->where('status', 'approved')->count()),
            Stat::make('Total Reject', Booking::query()->where('status', 'rejected')->count()),
        ];
    }

   
}
