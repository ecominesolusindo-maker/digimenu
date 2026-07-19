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
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $this->customerName ?: 'Walk-in Customer',
            'table_id' => $this->orderType === 'dine_in' ? $this->selectedTable : null,
            'total' => $total,
            'status' => 'pending',
            'payment_status' => 'paid',
            'order_type' => $this->orderType,
        ]);

        foreach ($this->cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        $this->cart = [];
        $this->customerName = '';
        $this->selectedTable = null;

        Notification::make()->title('Order placed successfully')->success()->send();
    }

    protected function getViewData(): array
    {
        return [
            'menuItems' => MenuItem::where('is_available', true)
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
                ->get(),
            'tables' => Table::all(),
        ];
    }
}
