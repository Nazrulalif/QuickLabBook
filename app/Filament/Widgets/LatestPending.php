<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\BookingResource;
use App\Models\Booking;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPending extends BaseWidget
{
    
    protected int| string| array $columnSpan= 'full';
    protected static ?int $sort =2;
    public function table(Table $table): Table
    {
        return $table
            ->heading('Latest Booking Pending')
            ->query(BookingResource::getEloquentQuery()->where('status', 'pending'))
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('itemName.name')
                    ->label('Item')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('start_at')
                    ->label('Book Start')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->label('Book End')
                    ->date('d/m/Y')
                    ->sortable(),
                    BadgeColumn::make('status')
                    ->colors([
                        'primary' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                        'warning' => 'return',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ])
                ->recordUrl(fn(Booking $record) => BookingResource::getUrl('edit', ['record' => $record]))
                ->actions([
                    Action::make('Edit')
                    ->url(fn(Booking $record): string => BookingResource::getUrl('edit', ['record' => $record]))
                    ->color('primary')
                    ->icon('heroicon-o-pencil-square'),
                ]);;
    }
}
