<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Order;
use App\Models\OrderItem;

class Checkout extends Component
{
    public $restaurant;
    public $tableToken = null;
    public $table = null;

    public $cart = []; // Array of items
    public $customerName = '';
    public $customerPhone = '';
    
    protected $rules = [
        'customerName' => 'required|min:3',
        'customerPhone' => 'nullable|min:10',
    ];

    public function mount($slug, $token = null)
    {
        $this->restaurant = Restaurant::where('slug', $slug)->firstOrFail();
        $this->tableToken = $token === 'takeaway' ? null : $token;

        if ($this->tableToken) {
            $this->table = Table::withoutGlobalScopes()
                ->where('restaurant_id', $this->restaurant->id)
                ->where('qr_code_token', $this->tableToken)
                ->first();
        }

        // Load cart from session (format: [itemId => ['qty', 'name', 'price', 'image']])
        $this->cart = session('cart_' . $this->restaurant->id, []);
    }

    public function placeOrder()
    {
        $this->validate();

        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty!');
            return;
        }

        // Calculate total
        $total = array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $this->cart));

        // Create Order
        $order = Order::withoutGlobalScopes()->create([
            'restaurant_id'  => $this->restaurant->id,
            'table_id'       => $this->table ? $this->table->id : null,
            'customer_name'  => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'subtotal'       => $total,
            'total'          => $total,
            'status'         => 'pending',
            'payment_status' => 'unpaid',
            'order_type'     => $this->table ? 'dine_in' : 'takeaway',
            'source'         => 'qr',
        ]);

        // Create Order Items — use correct column names from migration
        foreach ($this->cart as $itemId => $item) {
            OrderItem::withoutGlobalScopes()->create([
                'order_id'        => $order->id,
                'menu_item_id'    => (int) $itemId,
                'qty'             => $item['qty'],
                'price_at_order'  => $item['price'],
                'notes'           => null,
                'selected_variant'=> null,
                'selected_addons' => null,
            ]);
        }

        // Clear cart from session
        session()->forget('cart_' . $this->restaurant->id);
        $this->cart = [];

        session()->flash('success', 'Order placed successfully! Please wait for confirmation.');

        $routeParams = ['slug' => $this->restaurant->slug];
        if ($this->tableToken) $routeParams['token'] = $this->tableToken;

        return redirect()->route('customer.menu', $routeParams);
    }

    public function render()
    {
        return view('livewire.customer.checkout')->layout('components.layouts.customer');
    }
}
