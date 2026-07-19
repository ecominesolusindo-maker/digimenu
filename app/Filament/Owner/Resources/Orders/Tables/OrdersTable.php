<?php

namespace App\Filament\Owner\Resources\Orders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->searchable(),
                TextColumn::make('customer_name')->searchable(),
                TextColumn::make('order_type')->badge(),
                TextColumn::make('status')->label('Kitchen Status')->badge()->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'preparing' => 'primary',
                    'ready' => 'success',
                    'served' => 'gray',
                    'completed' => 'gray',
                    default => 'gray',
                }),
                TextColumn::make('payment_status')->label('Payment')->badge()->color(fn (string $state): string => match ($state) {
                    'paid' => 'success',
                    'unpaid' => 'danger',
                    default => 'warning',
                }),
                TextColumn::make('total')->money('idr')->sortable()->label('Total'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
