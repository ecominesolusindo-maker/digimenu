<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
                TextInput::make('password')->password()->dehydrated(fn ($state) => filled($state))->required(fn (string $context): bool => $context === 'create'),
                Select::make('role')->options([
                    'super_admin' => 'Super Admin',
                    'owner' => 'Restaurant Owner',
                ])->required(),
                Select::make('restaurant_id')->relationship('restaurant', 'name')->nullable(),
            ]);
    }
}
