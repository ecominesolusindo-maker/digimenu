<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Menu Catalog (Left, 2 cols) -->
        <div class="lg:col-span-2 flex flex-col space-y-4">
            <!-- Search -->
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search menu..." 
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
            
            <!-- Items Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 h-[600px] overflow-y-auto pr-2 pb-4">
                @forelse($menuItems as $item)
                    <div wire:click="addToCart({{ $item->id }})" class="cursor-pointer bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:border-primary-500 transition">
                        @if($item->image)
                            <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-32 object-cover">
                        @else
                            <div class="w-full h-32 bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-400">
                                <x-heroicon-o-photo class="w-8 h-8" />
                            </div>
                        @endif
                        <div class="p-3">
                            <h3 class="font-bold text-sm truncate">{{ $item->name }}</h3>
                            <p class="text-primary-600 font-bold mt-1 text-sm">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        No menu items found.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cart (Right, 1 col) -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col h-[650px]">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-bold">Current Order</h2>
            </div>
            
            <!-- Cart Items -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @forelse($cart as $index => $item)
                    <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-900 p-2 rounded-lg border border-gray-100 dark:border-gray-700">
                        <div class="flex-1 truncate pr-2">
                            <p class="font-bold text-sm truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-gray-500">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300">
                                <x-heroicon-o-minus class="w-4 h-4" />
                            </button>
                            <span class="w-4 text-center font-bold text-sm">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300">
                                <x-heroicon-o-plus class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 italic mt-10">Cart is empty</p>
                @endforelse
            </div>

            <!-- Checkout Section -->
            <div class="p-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                <div class="grid grid-cols-2 gap-2">
                    <button wire:click="$set('orderType', 'dine_in')" class="py-2 rounded-lg text-sm font-bold border transition {{ $orderType === 'dine_in' ? 'bg-primary-500 text-white border-primary-600' : 'bg-gray-50 text-gray-700 border-gray-300' }}">
                        Dine-in
                    </button>
                    <button wire:click="$set('orderType', 'takeaway')" class="py-2 rounded-lg text-sm font-bold border transition {{ $orderType === 'takeaway' ? 'bg-primary-500 text-white border-primary-600' : 'bg-gray-50 text-gray-700 border-gray-300' }}">
                        Takeaway
                    </button>
                </div>

                @if($orderType === 'dine_in')
                    <select wire:model="selectedTable" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        <option value="">Select Table...</option>
                        @foreach($tables as $table)
                            <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ $table->status }})</option>
                        @endforeach
                    </select>
                @endif

                <input type="text" wire:model="customerName" placeholder="Customer Name (Optional)" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">

                @php
                    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                @endphp
                
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>Total</span>
                    <span class="text-primary-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <button wire:click="placeOrder" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-bold shadow-md transition" wire:loading.attr="disabled">
                    <span wire:loading.remove>Place Order</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
        </div>
    </div>
</x-filament-panels::page>
