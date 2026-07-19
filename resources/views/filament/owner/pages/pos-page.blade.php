<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        
        <!-- Menu Catalog (Left, 2 cols) -->
        <div class="lg:col-span-2 flex flex-col space-y-6">
            <!-- Search -->
            <x-filament::input.wrapper>
                <x-filament::input type="text" wire:model.live.debounce.300ms="search" placeholder="Search menu..." />
            </x-filament::input.wrapper>
            
            <!-- Items Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 h-[calc(100vh-16rem)] overflow-y-auto pr-2 pb-4">
                @forelse($menuItems as $item)
                    <div wire:click="addToCart({{ $item->id }})" class="cursor-pointer bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-200 dark:border-white/10 overflow-hidden hover:ring-2 hover:ring-primary-500 transition duration-200 group">
                        <div class="w-full h-36 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <x-filament::icon icon="heroicon-o-photo" class="w-10 h-10 text-gray-300 dark:text-gray-600" />
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-primary-600 text-white text-xs font-bold px-2 py-1 rounded-lg shadow">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="p-4">
                            <h3 class="font-bold text-sm text-gray-900 dark:text-white group-hover:text-primary-600 transition truncate">{{ $item->name }}</h3>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 text-gray-400">
                        <x-filament::icon icon="heroicon-o-x-circle" class="w-12 h-12 mb-3 opacity-50" />
                        <p>No menu items found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Cart (Right, 1 col) -->
        <x-filament::section class="sticky top-6">
            <x-slot name="heading">
                Current Order
            </x-slot>
            
            <!-- Cart Items -->
            <div class="max-h-[40vh] overflow-y-auto pr-2 space-y-3 -mt-2 mb-4">
                @forelse($cart as $index => $item)
                    <div class="flex justify-between items-center bg-gray-50 dark:bg-white/5 p-3 rounded-xl border border-gray-100 dark:border-white/5">
                        <div class="flex-1 truncate pr-3">
                            <p class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $item['name'] }}</p>
                            <p class="text-xs text-primary-600 font-bold mt-0.5">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex items-center space-x-3 bg-white dark:bg-gray-800 rounded-lg p-1 border border-gray-200 dark:border-white/10">
                            <button wire:click="updateQuantity({{ $index }}, 'decrease')" class="p-1 text-gray-500 hover:text-red-500 transition">
                                <x-filament::icon icon="heroicon-o-minus" class="w-4 h-4" />
                            </button>
                            <span class="w-5 text-center font-bold text-sm text-gray-900 dark:text-white">{{ $item['quantity'] }}</span>
                            <button wire:click="updateQuantity({{ $index }}, 'increase')" class="p-1 text-gray-500 hover:text-primary-500 transition">
                                <x-filament::icon icon="heroicon-o-plus" class="w-4 h-4" />
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400">
                        <x-filament::icon icon="heroicon-o-shopping-bag" class="w-12 h-12 mx-auto mb-2 opacity-50" />
                        <p class="text-sm italic">Cart is empty</p>
                    </div>
                @endforelse
            </div>

            <!-- Checkout Section -->
            <div class="pt-4 border-t border-gray-200 dark:border-white/10 space-y-4">
                <div class="flex bg-gray-100 dark:bg-gray-900 rounded-lg p-1">
                    <button wire:click="$set('orderType', 'dine_in')" class="flex-1 py-2 text-sm font-bold rounded-md transition {{ $orderType === 'dine_in' ? 'bg-white dark:bg-gray-700 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        Dine-in
                    </button>
                    <button wire:click="$set('orderType', 'takeaway')" class="flex-1 py-2 text-sm font-bold rounded-md transition {{ $orderType === 'takeaway' ? 'bg-white dark:bg-gray-700 text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        Takeaway
                    </button>
                </div>

                @if($orderType === 'dine_in')
                    <div>
                        <select wire:model="selectedTable" class="w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-white/10 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block p-2.5">
                            <option value="">Select Table...</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}">Table {{ $table->table_number }} ({{ $table->status }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <x-filament::input.wrapper>
                    <x-filament::input type="text" wire:model="customerName" placeholder="Customer Name (Optional)" />
                </x-filament::input.wrapper>

                @php
                    $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
                @endphp
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-gray-500 dark:text-gray-400 font-medium">Total</span>
                    <span class="text-2xl font-extrabold text-primary-600 dark:text-primary-400">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <x-filament::button wire:click="placeOrder" color="primary" size="lg" class="w-full justify-center">
                    Pay / Place Order
                </x-filament::button>
            </div>
        </x-filament::section>
    </div>
</x-filament-panels::page>
