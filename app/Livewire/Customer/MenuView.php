<?php

namespace App\Livewire\Customer;

use Livewire\Component;
use App\Models\Restaurant;
use App\Models\MenuCategory;
use App\Models\MenuItem;
use App\Models\Table;

class MenuView extends Component
{
    public $restaurant;
    public $tableToken = null;
    public $table = null;
    public $cart = []; // ['item_id' => ['qty' => 1, 'name' => '', 'price' => 0]]
    public $showCart = false;

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

        // Restore cart from session
        $sessionKey = 'cart_' . $this->restaurant->id;
        $this->cart = session($sessionKey, []);
    }

    public function addToCart($itemId)
    {
        $item = MenuItem::find($itemId);
        if (!$item) return;

        $key = (string) $itemId;
        if (isset($this->cart[$key])) {
            $this->cart[$key]['qty']++;
        } else {
            $this->cart[$key] = [
                'qty'   => 1,
                'name'  => $item->name,
                'price' => (float) $item->price,
                'image' => $item->image,
            ];
        }
        $this->saveCart();
    }

    public function removeFromCart($itemId)
    {
        $key = (string) $itemId;
        if (isset($this->cart[$key])) {
            $this->cart[$key]['qty']--;
            if ($this->cart[$key]['qty'] <= 0) {
                unset($this->cart[$key]);
            }
        }
        $this->saveCart();
    }

    public function deleteFromCart($itemId)
    {
        unset($this->cart[(string) $itemId]);
        $this->saveCart();
    }

    public function toggleCart()
    {
        $this->showCart = !$this->showCart;
    }

    public function getCartCountProperty()
    {
        return array_sum(array_column($this->cart, 'qty'));
    }

    public function getCartTotalProperty()
    {
        return array_sum(array_map(fn($i) => $i['qty'] * $i['price'], $this->cart));
    }

    public function goToCheckout()
    {
        $token = $this->tableToken ?? 'takeaway';
        return $this->redirect(route('customer.checkout', [
            'slug'  => $this->restaurant->slug,
            'token' => $token,
        ]));
    }

    private function saveCart()
    {
        session(['cart_' . $this->restaurant->id => $this->cart]);
    }

    public function render()
    {
        $categories = MenuCategory::withoutGlobalScopes()
            ->where('restaurant_id', $this->restaurant->id)
            ->with(['menuItems' => function ($query) {
                $query->where('is_available', true);
            }])
            ->orderBy('sort_order')
            ->get();

        return view('livewire.customer.menu-view', [
            'categories' => $categories,
            'cartCount'  => $this->cartCount,
            'cartTotal'  => $this->cartTotal,
        ])->layout('components.layouts.customer');
    }
}
