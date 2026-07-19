<?php

namespace App\Filament\Owner\Resources\MenuItems\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class MenuItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')->relationship('category', 'name')->required(),
                TextInput::make('name')->required()->maxLength(255),
                Textarea::make('description'),
                TextInput::make('price')->numeric()->required(),
                TextInput::make('cost_price')->numeric(),
                FileUpload::make('image')->image()->directory('menu-items')->visibility('private'),
                Toggle::make('is_available')->default(true),
                Repeater::make('variants')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('price_adjustment')->numeric()->default(0),
                ]),
                Repeater::make('addons')->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('price')->numeric()->default(0),
                ]),
            ]);
    }
}
