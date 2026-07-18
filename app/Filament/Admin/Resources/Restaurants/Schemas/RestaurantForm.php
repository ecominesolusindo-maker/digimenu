<?php

namespace App\Filament\Admin\Resources\Restaurants\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\DatePicker;

class RestaurantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Textarea::make('description'),
                Toggle::make('is_active')->default(true),
                DatePicker::make('subscription_expires_at')->label('Subscription Valid Until'),
            ]);
    }
}
