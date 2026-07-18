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
        $this->tableToken = $token;

        if ($this->tableToken) {
            $this->table = Table::withoutGlobalScopes()
                ->where('restaurant_id', $this->restaurant->id)
                ->where('qr_code_token', $this->tableToken)
                ->first();
        }
    }

    public function placeOrder()
    {
        $this->validate();

        // Check if cart is empty
        if (empty($this->cart)) {
            session()->flash('error', 'Cart is empty!');
            return;
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += ($item['price'] * $item['quantity']);
        }
        $total = $subtotal; // Add tax/service if needed

        // Generate Order Number
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // Create Order
        $order = Order::withoutGlobalScopes()->create([
            'restaurant_id' => $this->restaurant->id,
            'table_id' => $this->table ? $this->table->id : null,
            'order_number' => $orderNumber,
            'customer_name' => $this->customerName,
            'customer_phone' => $this->customerPhone,
            'total_amount' => $total,
            'status' => 'pending', // Awaiting confirmation/payment
            'payment_status' => 'unpaid',
            'order_type' => $this->table ? 'dine_in' : 'takeaway',
        ]);

        // Create Order Items
        foreach ($this->cart as $item) {
            OrderItem::withoutGlobalScopes()->create([
                'order_id' => $order->id,
                'menu_item_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'notes' => $item['notes'] ?? null,
                'variants' => $item['variants'] ?? null,
                'addons' => $item['addons'] ?? null,
            ]);
        }

        // Clear cart
        $this->cart = [];
        
        session()->flash('success', 'Order placed successfully! Your order number is ' . $orderNumber);
        return redirect()->route('customer.menu', ['slug' => $this->restaurant->slug, 'token' => $this->tableToken]);
    }

    public function render()
    {
        return view('livewire.customer.checkout')->layout('components.layouts.customer');
    }
}
