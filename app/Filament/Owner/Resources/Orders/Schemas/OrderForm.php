<?php

namespace App\Filament\Owner\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number'),
                TextInput::make('customer_name'),
                TextInput::make('status'),
                TextInput::make('total'),
                Repeater::make('orderItems')
                    ->relationship('orderItems')
                    ->schema([
                        TextInput::make('menuItem.name')->label('Item'),
                        TextInput::make('qty')->label('Quantity'),
                        TextInput::make('subtotal'),
                    ])
                    ->columnSpanFull(),
            ])->disabled();
    }
}
