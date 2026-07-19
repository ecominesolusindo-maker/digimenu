<x-filament-panels::page>
    <div wire:poll.5s>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($orders as $order)
                <x-filament::section>
                    <x-slot name="heading">
                        Order #{{ $order->order_number ?: 'N/A' }}
                    </x-slot>
                    
                    <x-slot name="description">
                        <div class="flex flex-col gap-1 mt-1">
                            <span class="font-bold text-gray-900 dark:text-white">{{ $order->customer_name }}</span>
                            <div class="flex items-center gap-2">
                                <x-filament::badge :color="$order->order_type === 'dine_in' ? 'info' : 'warning'">
                                    {{ $order->order_type === 'dine_in' && $order->table ? 'Table ' . $order->table->table_number : 'Takeaway' }}
                                </x-filament::badge>
                                <span class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </x-slot>

                    <ul class="divide-y divide-gray-200 dark:divide-white/10 -mt-2">
                        @foreach($order->orderItems as $item)
                            <li class="py-3 flex items-start gap-3">
                                <x-filament::badge color="gray" size="sm" class="mt-0.5">
                                    {{ $item->qty }}x
                                </x-filament::badge>
                                <div>
                                    <span class="font-bold text-gray-800 dark:text-gray-200">{{ $item->menuItem ? $item->menuItem->name : 'Unknown Item' }}</span>
                                    @if($item->notes)
                                        <p class="text-sm text-gray-500 dark:text-gray-400 italic mt-1">{{ $item->notes }}</p>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>

                    <x-slot name="footerActions">
                        @if($order->status === 'pending')
                            <x-filament::button wire:click="updateOrderStatus({{ $order->id }}, 'preparing')" color="warning" icon="heroicon-o-fire" class="w-full justify-center">
                                Start Preparing
                            </x-filament::button>
                        @elseif($order->status === 'preparing')
                            <x-filament::button wire:click="updateOrderStatus({{ $order->id }}, 'ready')" color="success" icon="heroicon-o-check-circle" class="w-full justify-center">
                                Mark as Ready
                            </x-filament::button>
                        @endif
                    </x-slot>
                </x-filament::section>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-12">
                    <x-filament::icon icon="heroicon-o-check-badge" class="w-16 h-16 text-gray-400" />
                    <h3 class="mt-4 text-xl font-bold text-gray-500">All caught up!</h3>
                    <p class="text-gray-400">No active orders in the kitchen.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-filament-panels::page>
