<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\CamperRegistration;
use App\Models\GroupEvent;
use App\Models\Payment;
use Filament\Actions;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';

    protected static \UnitEnum|string|null $navigationGroup = 'Módulo Financiero';

    protected static ?string $modelLabel = 'Pago';

    protected static ?string $pluralModelLabel = 'Pagos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detalles del Pago Polimórfico')
                    ->schema([
                        Select::make('payable_type')
                            ->label('Tipo de Entidad a Cobrar')
                            ->options([
                                CamperRegistration::class => 'Registro de Acampante',
                                GroupEvent::class => 'Evento de Grupo',
                            ])
                            ->required(),
                        TextInput::make('payable_id')
                            ->label('ID de Entidad')
                            ->numeric()
                            ->required(),
                        TextInput::make('amount')
                            ->label('Monto ($)')
                            ->numeric()
                            ->prefix('$')
                            ->required(),
                        Select::make('payment_type')
                            ->label('Tipo de Pago')
                            ->options([
                                'deposit' => 'Depósito / Anticipo',
                                'partial' => 'Pago Parcial',
                                'balance' => 'Saldo Finiquito',
                            ])
                            ->required(),
                        Select::make('status')
                            ->label('Estado del Pago')
                            ->options([
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'partial' => 'Parcial',
                                'overdue' => 'Vencido',
                            ])
                            ->default('pending')
                            ->required(),
                        DatePicker::make('due_date')
                            ->label('Fecha Vencimiento')
                            ->required(),
                        DateTimePicker::make('paid_at')
                            ->label('Fecha / Hora de Pago'),
                        Textarea::make('notes')
                            ->label('Notas del Pago')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('payable_type')->label('Tipo Entidad')->formatStateUsing(fn ($state) => class_basename($state)),
                Tables\Columns\TextColumn::make('payable_id')->label('ID Entidad'),
                Tables\Columns\TextColumn::make('amount')->label('Monto')->money('USD')->sortable(),
                Tables\Columns\TextColumn::make('payment_type')->label('Tipo Pago')->badge(),
                Tables\Columns\TextColumn::make('status')->label('Estado')->badge(),
                Tables\Columns\TextColumn::make('due_date')->label('Vencimiento')->date()->sortable(),
                Tables\Columns\TextColumn::make('paid_at')->label('Fecha Pago')->dateTime()->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'partial' => 'Parcial',
                        'overdue' => 'Vencido',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
