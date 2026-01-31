<?php

namespace App\Filament\Pages;

use UnitEnum;
use BackedEnum;
use App\Models\Flight;
use Filament\Pages\Page;
use Filament\Tables\Table;
use App\Services\FlightService;
use Filament\Support\Colors\Color;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Filters\SelectFilter;

use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;

class FlightInformation extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    protected FlightService $flightService;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-paper-airplane';

    protected static string | UnitEnum | null $navigationGroup = 'Flight Management';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.flight-information';

    public function getTitle(): string
    {
        return 'Flight Information';
    }

    public function mount(FlightService $flightService)
    {
        $this->flightService = $flightService;
    }

    public function table(Table $table): Table
    {
        return $table
            ->records(fn (): array => $this->flightService->getAllFlights())
            ->columns([
                TextColumn::make('airline_name')
                    ->label('Airline')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('flight_number')
                    ->label('Flight No.')
                    ->badge()
                    ->color('info')
                    ->searchable(),
                TextColumn::make('route')
                    ->label('Route')
                    ->formatStateUsing(fn ($record) => $record->origin . ' → ' . $record->destination),
                TextColumn::make('departure_time')
                    ->label('Departure')
                    ->date('H:i') 
                    ->formatStateUsing(fn ($state) => \Carbon\Carbon::parse($state)->format('H:i')),
                TextColumn::make('duration')
                    ->label('Duration'),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'One-way' => 'success',
                        'Round-trip' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('class')
                    ->label('Class')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Economy' => 'success',
                        'Business' => 'warning',
                        'First' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('price_formatted')
                    ->label('Price')
                    ->color('primary')
                    ->weight('bold'),
            ])
            ->filters([
                SelectFilter::make('route')
                    ->label('Route (From - To)')
                    ->options([
                        'CGK-DPS' => 'Jakarta (CGK) → Bali (DPS)',
                        'CGK-SUB' => 'Jakarta (CGK) → Surabaya (SUB)',
                        'CGK-JOG' => 'Jakarta (CGK) → Yogyakarta (JOG)',
                        'SUB-DPS' => 'Surabaya (SUB) → Bali (DPS)',
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['value'])) {
                            return $query;
                        }
                        
                        [$origin, $destination] = explode('-', $data['value']);
                        
                        return $query->where('origin', $origin)
                                     ->where('destination', $destination);
                    }),
                SelectFilter::make('type')
                    ->options([
                        'One-way' => 'One-way',
                        'Round-trip' => 'Round-trip',
                    ]),
                SelectFilter::make('class')
                    ->options([
                        'Economy' => 'Economy',
                        'Business' => 'Business',
                        'First' => 'First Class',
                    ]),
            ])
            ->paginated(false); 
    }
}
