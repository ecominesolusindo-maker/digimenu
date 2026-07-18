<?php

namespace App\Filament\Owner\Widgets;

use App\Models\MenuItem;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\DB;

class TopMenuWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';
    protected static ?string $heading = 'Top 5 Best Selling Items';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MenuItem::query()
                    ->select('menu_items.*', DB::raw('SUM(order_items.quantity) as total_sold'))
                    ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.payment_status', 'paid')
                    ->groupBy('menu_items.id')
                    ->orderBy('total_sold', 'desc')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Item Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Category'),
                Tables\Columns\TextColumn::make('price')
                    ->money('idr')
                    ->label('Price'),
                Tables\Columns\TextColumn::make('total_sold')
                    ->label('Total Quantity Sold')
                    ->badge()
                    ->color('success'),
            ])
            ->paginated(false);
    }
}
