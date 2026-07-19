<?php

namespace App\Filament\Cashier\Pages;

use App\Filament\Owner\Pages\PosPage;

class PosDashboard extends PosPage
{
    protected static ?string $slug = ''; // Makes this the default page at /cashier

    public static function getNavigationIcon(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'heroicon-o-calculator';
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Point of Sale';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operations';
    }
}
