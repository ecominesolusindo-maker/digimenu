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
        ])->layout('components.layouts.customer');
    }
}
