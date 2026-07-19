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
        $restaurantId = auth()->user()?->restaurant_id;

        return $table
            ->query(
                MenuItem::query()
                    ->select('menu_items.*', DB::raw('SUM(order_items.qty) as total_sold'))
                    ->join('order_items', 'menu_items.id', '=', 'order_items.menu_item_id')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.payment_status', 'paid')
                    ->where('menu_items.restaurant_id', $restaurantId)
                    ->groupBy('menu_items.id', 'menu_items.name', 'menu_items.price', 'menu_items.restaurant_id', 'menu_items.category_id', 'menu_items.image', 'menu_items.description', 'menu_items.is_available', 'menu_items.created_at', 'menu_items.updated_at')
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
