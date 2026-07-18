<div>
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-6 max-w-2xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Complete Your Order</h2>
        
        <form wire:submit="placeOrder">
            <!-- Customer Info -->
            <div class="space-y-4 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" wire:model="customerName" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm px-4 py-2 border" placeholder="John Doe">
                    @error('customerName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Phone Number (Optional)</label>
                    <input type="text" wire:model="customerPhone" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm px-4 py-2 border" placeholder="08123456789">
                    @error('customerPhone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-gray-50 p-4 rounded-lg mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-4">Order Summary</h3>
                @if(empty($cart))
                    <p class="text-sm text-gray-500 italic">Your cart is empty.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php $sub = $item['price'] * $item['quantity']; $total += $sub; @endphp
                            <li class="py-3 flex justify-between">
                                <div>
                                    <span class="font-medium text-gray-900">{{ $item['quantity'] }}x {{ $item['name'] }}</span>
                                    @if(!empty($item['notes']))
                                        <p class="text-xs text-gray-500">{{ $item['notes'] }}</p>
                                    @endif
                                </div>
                                <span class="text-gray-900">Rp {{ number_format($sub, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <div class="mt-4 pt-4 border-t border-gray-200 flex justify-between">
                        <span class="font-bold text-lg">Total</span>
                        <span class="font-bold text-lg text-orange-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                @endif
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-between">
                <a href="{{ route('customer.menu', ['slug' => $restaurant->slug, 'token' => $tableToken]) }}" class="text-sm text-orange-600 hover:text-orange-800 font-medium">
                    &larr; Back to Menu
                </a>
                <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded-md font-bold hover:bg-orange-700 transition shadow flex items-center" wire:loading.attr="disabled">
                    <span wire:loading.remove>Place Order</span>
                    <span wire:loading>Processing...</span>
                </button>
            </div>
        </form>
    </div>
</div>
