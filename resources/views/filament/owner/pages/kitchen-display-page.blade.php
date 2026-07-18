<x-filament-panels::page>
    <!-- Use wire:poll to refresh orders automatically every 5 seconds -->
    <div wire:poll.5s class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($orders as $order)
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md border-t-4 flex flex-col h-full {{ $order->status === 'preparing' ? 'border-primary-500' : 'border-warning-500' }}">
                
                <!-- Order Header -->
                <div class="p-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-start bg-gray-50 dark:bg-gray-900/50 rounded-t-xl">
                    <div>
                        <h3 class="font-bold text-lg">#{{ $order->order_number }}</h3>
                        <p class="text-sm text-gray-500">{{ $order->customer_name }}</p>
                    </div>
                    <div class="text-right">
                        <span class="inline-block px-2 py-1 text-xs font-bold rounded-full {{ $order->order_type === 'dine_in' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $order->order_type === 'dine_in' && $order->table ? 'Table ' . $order->table->table_number : 'Takeaway' }}
                        </span>
                        <p class="text-xs text-gray-400 mt-1" title="{{ $order->created_at }}">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                <!-- Order Items -->
                <div class="p-4 flex-1 overflow-y-auto space-y-3">
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($order->orderItems as $item)
                            <li class="py-2 flex items-start space-x-3">
                                <span class="font-bold text-lg min-w-[1.5rem]">{{ $item->quantity }}x</span>
                                <div>
                                    <p class="font-bold">{{ $item->menuItem ? $item->menuItem->name : 'Unknown Item' }}</p>
                                    @if($item->notes)
                                        <p class="text-xs text-red-500 bg-red-50 dark:bg-red-900/20 px-2 py-1 mt-1 rounded italic">{{ $item->notes }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <!-- Action Buttons -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 mt-auto">
                    @if($order->status === 'pending')
                        <button wire:click="updateOrderStatus({{ $order->id }}, 'preparing')" class="w-full bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-4 rounded-lg shadow transition text-center flex justify-center items-center">
                            <x-heroicon-o-fire class="w-5 h-5 mr-2" />
                            Start Preparing
                        </button>
                    @elseif($order->status === 'preparing')
                        <button wire:click="updateOrderStatus({{ $order->id }}, 'ready')" class="w-full bg-success-500 hover:bg-success-600 text-white font-bold py-3 px-4 rounded-lg shadow transition text-center flex justify-center items-center">
                            <x-heroicon-o-check-circle class="w-5 h-5 mr-2" />
                            Mark as Ready
                        </button>
                    @endif
                </div>

            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center py-20 text-gray-400">
                <x-heroicon-o-check-badge class="w-20 h-20 mb-4 text-gray-300 dark:text-gray-600" />
                <h3 class="text-2xl font-bold text-gray-500">All caught up!</h3>
                <p>No active orders in the kitchen.</p>
            </div>
        @endforelse
    </div>
</x-filament-panels::page>
