<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
use App\Mail\StatusChangedNotification;
use App\Models\Booking;
use App\Models\Stock;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Mail;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Group::make([
                    Section::make('Booking Information')
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label("Applicant's Full Name")
                                ->required()
                                ->disabled(),

                            Forms\Components\TextInput::make('no_matric')
                                ->required()
                                ->disabled(),

                            Forms\Components\TextInput::make('email')
                                ->email()
                                ->required()
                                ->disabled(),

                            Select::make('level_study')
                                ->label('Level of Study')
                                ->required()
                                ->options([
                                    'Sarjana Muda' => 'Sarjana Muda',
                                    'Sarjana' => 'Sarjana',
                                    'Doktor Falsafah' => 'Doktor Falsafah',
                                ])
                                ->disabled(),

                            Forms\Components\TextInput::make('year_study')
                                ->label('Year of Study')
                                ->numeric()
                                ->required()
                                ->disabled(),

                            

                            Forms\Components\DatePicker::make('start_at')
                                ->label('Start Date')
                                ->required()
                                // ->rules(['after_or_equal:today'])
                                ->reactive()
                                ->disabled(),

                            Forms\Components\DatePicker::make('end_at')
                                ->label('End Date')
                                ->required()
                                ->rules(['after_or_equal:start_at'])
                                ->reactive()
                                ->disabled(),

                            MarkdownEditor::make('purpose')
                                ->required()
                                ->columnSpanFull()
                                ->disabled(),
                        ])->columns(2),

                    Section::make('Items')
                        ->schema([
                            Repeater::make('bookingItem')
                                ->relationship()
                                ->schema([
                                    Select::make('stock_id')
                                        ->relationship('stock', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->disabled()
                                        ->distinct()
                                        ->columnSpan(3),

                                    TextInput::make('quantity')
                                        ->label('Quantity to Book')
                                        ->numeric()
                                        ->required()
                                        ->default(1)
                                        ->minValue(1)
                                        ->columnSpan(1)
                                        ->disabled(),
                                ])
                                ->deletable(false)
                                ->addable(false)
                                ->columns(4)
                                ->itemLabel(fn (array $state) => isset($state['stock_id']) && $state['stock_id']
                                    ? Stock::find($state['stock_id'])?->name
                                    : null),
                        ]),

                        Section::make('Booking Status')
                        ->schema([
                            ToggleButtons::make('status')
                            ->inline()
                            ->default('pending')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Approve',
                                'rejected' => 'Reject',
                                'return' => 'return',
                            ])
                            ->colors([
                                'pending' => 'primary',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'return' => 'info',

                            ])
                            ->icons([
                                'pending' => 'heroicon-m-sparkles',
                                'approved' => 'heroicon-m-check-badge',
                                'rejected' => 'heroicon-m-exclamation-circle',
                                'return' => 'heroicon-m-receipt-refund',

                            ])
                            ->afterStateUpdated(function ($state, $record) {
                                if ($state !== 'pending') {
                                    Mail::to($record->email)->send(new StatusChangedNotification($record, $state));
                                }
                            })
                            ->columnSpanFull(),

                            MarkdownEditor::make('comment')
                                ->label('Comments')
                                ->columnSpanFull(),
                        ])

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
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
                        'info' => 'return',
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
            ->filters([

            ])
            ->actions([
                ActionGroup::make([
                    // Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor():string|array|null {
        return static::getModel()::where('status', 'pending')->count() > 5 ? 'danger' : 'success';
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            // 'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
