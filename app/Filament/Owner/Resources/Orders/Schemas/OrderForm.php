<?php

namespace App\Filament\Owner\Resources\Orders\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number'),
                TextInput::make('customer_name'),
                Select::make('table_id')
                    ->relationship('table', 'table_number')
                    ->label('Table Number')
                    ->placeholder('Takeaway'),
                TextInput::make('status'),
                TextInput::make('total'),
                Repeater::make('orderItems')
                    ->relationship('orderItems')
                    ->schema([
                        Select::make('menu_item_id')
                            ->relationship('menuItem', 'name')
                            ->label('Item')
                            ->disabled(),
                        TextInput::make('qty')->label('Quantity'),
                        TextInput::make('subtotal'),
                    ])
                    ->columnSpanFull(),
            ])->disabled();
    }
}
