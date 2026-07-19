<?php

namespace App\Filament\Owner\Pages;

use Filament\Pages\Page;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Filament\Notifications\Notification;

class PosPage extends Page
{
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

    protected string $view = 'filament.owner.pages.pos-page';

    public $cart = [];
    public $search = '';
    public $orderType = 'dine_in';
    public $selectedTable = null;
    public $customerName = '';
    public $activeTab = 'new_order'; // 'new_order' or 'active_orders'

    public function addToCart($itemId)
    {
        $item = MenuItem::find($itemId);
        if (!$item) return;

        $found = false;
        foreach ($this->cart as &$cartItem) {
            if ($cartItem['id'] === $itemId) {
                $cartItem['quantity']++;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $this->cart[] = [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => 1,
            ];
        }
    }

    public function updateQuantity($index, $action)
    {
        if (!isset($this->cart[$index])) return;

        if ($action === 'increase') {
            $this->cart[$index]['quantity']++;
        } elseif ($action === 'decrease') {
            $this->cart[$index]['quantity']--;
            if ($this->cart[$index]['quantity'] <= 0) {
                unset($this->cart[$index]);
                $this->cart = array_values($this->cart); // reindex
            }
        }
    }

    public function placeOrder()
    {
        if (empty($this->cart)) {
            Notification::make()->title('Cart is empty')->danger()->send();
            return;
        }

        if ($this->orderType === 'dine_in' && empty($this->selectedTable)) {
            Notification::make()->title('Please select a table')->danger()->send();
            return;
        }

        $total = collect($this->cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        $order = Order::create([
            'restaurant_id' => auth()->user()->restaurant->id ?? 1,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $this->customerName ?: 'Walk-in Customer',
            'table_id' => $this->orderType === 'dine_in' ? $this->selectedTable : null,
            'subtotal' => $total,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'paid',
            'order_type' => $this->orderType,
            'source' => 'pos',
        ]);

        foreach ($this->cart as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $cartItem['id'],
                'qty' => $cartItem['quantity'],
                'price_at_order' => $cartItem['price'],
                'notes' => null,
            ]);
        }

        if ($this->orderType === 'dine_in') {
            Table::where('id', $this->selectedTable)->update(['status' => 'occupied']);
        }

        $this->cart = [];
        $this->customerName = '';
        $this->selectedTable = null;

        Notification::make()->title('Order placed successfully!')->success()->send();
    }

    public function processPayment($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->payment_status !== 'paid') {
            $order->update(['payment_status' => 'paid']);
            Notification::make()->title('Payment processed successfully!')->success()->send();
        }
    }

    public function getUnpaidOrdersProperty()
    {
        $restaurantId = auth()->user()->restaurant->id ?? 1;
        return Order::with(['table', 'items.menuItem'])
            ->where('restaurant_id', $restaurantId)
            ->where('payment_status', 'unpaid')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    protected function getViewData(): array
    {
        $restaurantId = auth()->user()->restaurant->id ?? 1;

        $menuItems = MenuItem::where('restaurant_id', $restaurantId)
            ->when($this->search, function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%');
            })->get();

        $tables = Table::where('restaurant_id', $restaurantId)
            ->get();

        return [
            'menuItems' => $menuItems,
            'tables' => $tables,
            'unpaidOrders' => $this->unpaidOrders,
        ];
    }
}
