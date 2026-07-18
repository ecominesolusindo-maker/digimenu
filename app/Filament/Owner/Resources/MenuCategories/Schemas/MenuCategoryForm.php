<?php

namespace App\Filament\Owner\Resources\MenuCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class MenuCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('sort_order')->numeric()->default(0),
            ]);
    }
}
