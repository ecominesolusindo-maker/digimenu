<?php

namespace App\Filament\Owner\Resources\MenuCategories\Pages;

use App\Filament\Owner\Resources\MenuCategories\MenuCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMenuCategory extends CreateRecord
{
    protected static string $resource = MenuCategoryResource::class;
}
