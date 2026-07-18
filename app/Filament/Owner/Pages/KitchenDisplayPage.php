<?php

namespace App\Filament\Owner\Pages;

use Filament\Pages\Page;
use App\Models\Order;

class KitchenDisplayPage extends Page
{
    public static function getNavigationIcon(): string | \Illuminate\Contracts\Support\Htmlable | null
    {
        return 'heroicon-o-fire';
    }

    public function getTitle(): string | \Illuminate\Contracts\Support\Htmlable
    {
        return 'Kitchen Display (KDS)';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Operations';
    }

    protected string $view = 'filament.owner.pages.kitchen-display-page';

    public function updateOrderStatus($orderId, $status)
    {
        $order = Order::find($orderId);
        if ($order) {
            $order->update(['status' => $status]);
        }
    }

    protected function getViewData(): array
    {
        return [
            'orders' => Order::with(['orderItems.menuItem', 'table'])
                ->whereIn('status', ['pending', 'preparing'])
                ->orderBy('created_at', 'asc')
                ->get(),
        ];
    }
}
