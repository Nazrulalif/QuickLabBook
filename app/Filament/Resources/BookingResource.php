<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Filament\Resources\BookingResource\RelationManagers;
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
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                        ->required(),
                        Forms\Components\TextInput::make('no_matric')
                        ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required(),
                        Select::make('level_study')
                        ->label('Level of Study')
                        ->required()
                        ->options([
                            'undergraduate' => 'Undergraduate',
                            'postgraduate' => 'Postgraduate',
                            'doctor of philosophy' => 'Doctor of Philosophy',
                        ]),
                        Forms\Components\TextInput::make('year_study')
                            ->label('Year of Study')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->required(),
                            ToggleButtons::make('status')
                            ->inline()
                            ->default('pending')
                            ->options([
                                'pending'=>'Pending',
                                'approved'=>'Approve',
                                'rejected'=>'Reject',
                            ])
                            ->colors([
                                'pending'=>'primary',
                                'approved'=>'success',
                            ])
                            ->icons([
                                'pending'=>'heroicon-m-sparkles',
                                'approved'=>'heroicon-m-check-badge',
                            ])
                            ->columnSpanFull(),
                            Forms\Components\DatePicker::make('start_at')
                            ->label('Start Date')
                            ->required()
                            ->rules([
                                'after_or_equal:today', // Ensures the start date is today or later
                            ])
                            ->reactive(), // To trigger a refresh when the value changes
    
                        Forms\Components\DatePicker::make('end_at')
                            ->label('End Date')
                            ->required()
                            ->rules([
                                'after_or_equal:start_at', // Ensures the end date is after or equal to the start date
                            ])
                            ->reactive(), // Reacts when the start date changes
                            MarkdownEditor::make('purpose')
                            ->required()
                            ->columnspanFull(),
                    ])->columns(2),

                    Section::make('Items')
                        ->schema([
                            Repeater::make('bookingItem')
                                ->relationship()
                                ->schema([
                                    // Select Stock
                                    Select::make('stock_id')
                                        ->relationship('stock', 'name')
                                        ->searchable()
                                        ->preload()
                                        ->required()
                                        ->distinct()
                                        ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                        ->columnSpan(2)
                                        ->reactive() // React when the stock_id changes
                                        ->afterStateUpdated(fn ($state, Set $set)=> $set('current_stock', Stock::find($state) ?->quantity ?? 0))
                                        ->afterStateHydrated(fn ($state, Set $set) => $set('current_stock', Stock::find($state)?->quantity ?? 0)), // Populate on load


                                    // Display Current Stock Quantity (Read-only)
                                    TextInput::make('current_stock')
                                        ->label('Current Stock')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated()
                                        ->columnSpan(1),

                                    // User Input for Quantity to Book
                                    TextInput::make('quantity')
                                    ->label('Quantity to Book')
                                    ->numeric()
                                    ->required()
                                    ->default(1)
                                    ->minValue(1)
                                    ->columnSpan(1)
                                    ->rule(function (callable $get) {
                                        $currentStock = $get('current_stock'); // Retrieve the current stock
                                        if (is_null($currentStock)) {
                                            return ''; // Skip the max rule if current_stock is null
                                        }
                                        return "max:$currentStock"; // Apply the max rule based on current stock
                                    }),
                                ])
                                ->columns(4)
                                ->itemLabel(function (array $state): ?string {
                                    return isset($state['stock_id']) && $state['stock_id']
                                        ? Stock::find($state['stock_id'])?->name
                                        : null;
                                }),
                        ])

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('itemName.name')
                    ->label('Item')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_at')
                    ->label('Book Start')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_at')
                    ->label('Book End')
                    ->date('d/m/Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                    SelectColumn::make('status')
                    ->options([
                        'pending'=>'Pending',
                        'approved'=>'Approve',
                        'rejected'=>'Reject',
                        'return'=>'Return',
                    ])
                    ->default('pending')
                    ->sortable()
                    ->searchable()
                    ->selectablePlaceholder(false),
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
                    Tables\Actions\ViewAction::make(),
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
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
