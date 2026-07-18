<?php

namespace App\Filament\Owner\Resources\Tables\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class TableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('table_number')->required()->maxLength(255),
                TextInput::make('qr_code_token')->disabled()->dehydrated(false)->hint('Auto-generated on save'),
                TextInput::make('seating_capacity')->numeric()->default(2)->required(),
                Select::make('status')->options([
                    'available' => 'Available',
                    'occupied' => 'Occupied',
                ])->default('available')->required(),
            ]);
    }
}
