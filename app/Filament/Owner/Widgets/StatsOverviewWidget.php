<?php

namespace App\Filament\Owner\Widgets;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $today = Carbon::today();
        
        // Revenue Today
        $revenueToday = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_amount');
            
        // Orders Today
        $ordersToday = Order::whereDate('created_at', $today)->count();
        
        // Items Sold Today
        $itemsSoldToday = OrderItem::whereHas('order', function($q) use ($today) {
                $q->whereDate('created_at', $today)->where('payment_status', 'paid');
            })->sum('quantity');

        return [
            Stat::make('Revenue Today', 'Rp ' . number_format($revenueToday, 0, ',', '.'))
                ->description('Total completed payments')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
                
            Stat::make('Orders Today', $ordersToday)
                ->description('All incoming orders')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('primary'),
                
            Stat::make('Items Sold Today', $itemsSoldToday)
                ->description('Total food/drinks sold')
                ->descriptionIcon('heroicon-m-cake')
                ->color('warning'),
        ];
    }
}
