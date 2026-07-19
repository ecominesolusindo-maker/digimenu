<x-filament-panels::page>
    <style>
        .pos-container { display: flex; flex-direction: column; gap: 1.5rem; }
        @media (min-width: 1024px) { .pos-container { flex-direction: row; align-items: flex-start; } }
        
        .pos-left { flex: 1; display: flex; flex-direction: column; gap: 1.5rem; width: 100%; }
        .pos-right { width: 100%; position: sticky; top: 1.5rem; }
        @media (min-width: 1024px) { .pos-right { width: 380px; flex-shrink: 0; } }

        /* Search Bar */
        .pos-search {
            width: 100%; padding: 0.875rem 1.25rem; border-radius: 1rem;
            border: 1px solid rgba(156, 163, 175, 0.3); background: var(--bg-color, #fff);
            font-size: 1rem; outline: none; transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
        .dark .pos-search { background: #1f2937; color: #fff; border-color: rgba(255,255,255,0.1); }
        .pos-search:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2); }

        /* Grid */
        .pos-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem; max-height: calc(100vh - 200px); overflow-y: auto; padding-right: 0.5rem;
        }

        /* Card */
        .pos-card {
            background: var(--bg-color, #fff); border-radius: 1rem; overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid rgba(156, 163, 175, 0.2);
            cursor: pointer; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
        }
        .dark .pos-card { background: #1f2937; border-color: rgba(255,255,255,0.05); }
        .pos-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1); border-color: #6366f1; }

        .pos-card-img { width: 100%; height: 120px; object-fit: cover; background: #f3f4f6; }
        .dark .pos-card-img { background: #374151; }
        
        .pos-card-body { padding: 0.75rem; display: flex; flex-direction: column; gap: 0.25rem; }
        .pos-card-title { font-weight: 700; font-size: 0.9rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--text-color, #111827); }
        .dark .pos-card-title { color: #f9fafb; }
        .pos-card-price { font-weight: 800; font-size: 0.95rem; color: #6366f1; }

        /* Cart Section */
        .pos-cart {
            background: var(--bg-color, #fff); border-radius: 1.25rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); border: 1px solid rgba(156, 163, 175, 0.2);
            display: flex; flex-direction: column; overflow: hidden;
        }
        .dark .pos-cart { background: #1f2937; border-color: rgba(255,255,255,0.05); }
        
        .pos-cart-header { padding: 1.25rem; border-bottom: 1px solid rgba(156, 163, 175, 0.2); font-weight: 800; font-size: 1.25rem; }
        .dark .pos-cart-header { border-bottom-color: rgba(255,255,255,0.1); color: #fff; }

        .pos-cart-items { max-height: 40vh; overflow-y: auto; padding: 1rem; display: flex; flex-direction: column; gap: 0.75rem; }
        
        .pos-cart-item {
            display: flex; justify-content: space-between; align-items: center;
            padding: 0.75rem; background: #f9fafb; border-radius: 0.75rem;
            border: 1px solid rgba(156, 163, 175, 0.2);
        }
        .dark .pos-cart-item { background: #111827; border-color: rgba(255,255,255,0.05); }

        .pos-cart-item-info { flex: 1; overflow: hidden; }
        .pos-cart-item-title { font-weight: 700; font-size: 0.9rem; color: #111827; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .dark .pos-cart-item-title { color: #fff; }
        .pos-cart-item-price { font-size: 0.8rem; color: #6366f1; font-weight: 700; }

        .pos-qty-controls { display: flex; align-items: center; gap: 0.5rem; background: #fff; padding: 0.25rem; border-radius: 0.5rem; border: 1px solid rgba(156, 163, 175, 0.3); }
        .dark .pos-qty-controls { background: #1f2937; border-color: rgba(255,255,255,0.1); }
        .pos-qty-btn { width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; background: #f3f4f6; border-radius: 0.375rem; border: none; cursor: pointer; color: #374151; font-weight: bold; }
        .dark .pos-qty-btn { background: #374151; color: #e5e7eb; }
        .pos-qty-btn:hover { background: #e5e7eb; }
        .dark .pos-qty-btn:hover { background: #4b5563; }
        .pos-qty-value { font-weight: 800; font-size: 0.9rem; min-width: 1.5rem; text-align: center; color: #111827; }
        .dark .pos-qty-value { color: #fff; }

        /* Checkout Area */
        .pos-checkout { padding: 1.25rem; border-top: 1px solid rgba(156, 163, 175, 0.2); display: flex; flex-direction: column; gap: 1rem; }
        .dark .pos-checkout { border-top-color: rgba(255,255,255,0.1); }

        .pos-tabs { display: flex; background: #f3f4f6; padding: 0.25rem; border-radius: 0.75rem; }
        .dark .pos-tabs { background: #111827; }
        .pos-tab { flex: 1; padding: 0.5rem; text-align: center; border-radius: 0.5rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; border: none; background: transparent; color: #6b7280; transition: all 0.2s; }
        .pos-tab.active { background: #fff; color: #6366f1; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .dark .pos-tab.active { background: #374151; color: #818cf8; }

        .pos-total-row { display: flex; justify-content: space-between; align-items: center; padding: 0.5rem 0; }
        .pos-total-label { font-size: 1rem; font-weight: 600; color: #6b7280; }
        .dark .pos-total-label { color: #9ca3af; }
        .pos-total-value { font-size: 1.5rem; font-weight: 900; color: #6366f1; }

        .pos-pay-btn {
            width: 100%; padding: 1rem; border-radius: 0.75rem; background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: white; font-weight: 800; font-size: 1.1rem; border: none; cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.4); transition: all 0.3s;
        }
        .pos-pay-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.5); }
        .pos-pay-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }
    </style>

    <div class="pos-container">
        
        <!-- Menu Catalog (Left) -->
        <div class="pos-left">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="🔍 Search menu items..." class="pos-search">
            
            <div class="pos-grid">
                @forelse($menuItems as $item)
                    <div wire:click="addToCart({{ $item->id }})" class="pos-card">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="pos-card-img" alt="{{ $item->name }}">
                        @else
                            <div class="pos-card-img" style="display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <svg style="width: 2rem; height: 2rem;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        <div class="pos-card-body">
                            <div class="pos-card-title">{{ $item->name }}</div>
                            <div class="pos-card-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                @empty
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: #9ca3af;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🍽️</div>
                        <p>No menu items found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cart (Right) -->
        <div class="pos-right">
            <div class="pos-cart">
                <div class="pos-cart-header">
                    🛒 Current Order
                </div>
                
                <div class="pos-cart-items">
                    @forelse($cart as $index => $item)
                        <div class="pos-cart-item">
                            <div class="pos-cart-item-info">
                                <div class="pos-cart-item-title">{{ $item['name'] }}</div>
                                <div class="pos-cart-item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</div>
                            </div>
                            <div class="pos-qty-controls">
                                <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="pos-qty-btn">-</button>
                                <span class="pos-qty-value">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $index }}, 'increase')" class="pos-qty-btn">+</button>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 2rem; color: #9ca3af; font-style: italic;">
                            Cart is empty
                        </div>
                    @endforelse
                </div>

                <div class="pos-checkout">
                    <div class="pos-tabs">
                        <button wire:click="$set('orderType', 'dine_in')" class="pos-tab {{ $orderType === 'dine_in' ? 'active' : '' }}">Dine-in</button>
                        <button wire:click="$set('orderType', 'takeaway')" class="pos-tab {{ $orderType === 'takeaway' ? 'active' : '' }}">Takeaway</button>
                    </div>

                    @if($orderType === 'dine_in')
                        <select wire:model="selectedTable" class="pos-search" style="padding: 0.6rem 1rem; border-radius: 0.75rem;">
                            <option value="">Select Table...</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ $table->status }})</option>
                            @endforeach
                        </select>
                    @endif

                    <input type="text" wire:model="customerName" placeholder="Customer Name (Optional)" class="pos-search" style="padding: 0.6rem 1rem; border-radius: 0.75rem;">

                    @php
                        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                    @endphp
                    
                    <div class="pos-total-row">
                        <span class="pos-total-label">Total</span>
                        <span class="pos-total-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button wire:click="placeOrder" class="pos-pay-btn" wire:loading.attr="disabled">
                        <span wire:loading.remove>Pay / Place Order</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
