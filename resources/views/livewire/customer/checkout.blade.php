<div>
    <div class="max-w-md mx-auto pb-24">
        
        <!-- Header / Back button -->
        <div class="mb-6 flex items-center">
            <a href="{{ route('customer.menu', ['slug' => $restaurant->slug, 'token' => $tableToken]) }}" class="w-10 h-10 bg-white rounded-full flex items-center justify-center text-slate-600 shadow-sm border border-slate-200 hover:bg-slate-50 transition active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h2 class="text-xl font-extrabold text-slate-900 ml-4">Checkout</h2>
        </div>
        
        <form wire:submit="placeOrder" class="space-y-6">
            <!-- Customer Info Card -->
            <div class="bg-white rounded-3xl p-6 shadow-xl shadow-slate-200/40 border border-slate-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-brand-500"></div>
                <h3 class="font-bold text-lg text-slate-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Your Information
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Name</label>
                        <input type="text" wire:model="customerName" class="w-full rounded-xl bg-slate-50 border-transparent focus:border-brand-500 focus:bg-white focus:ring-0 text-slate-900 font-medium px-4 py-3 transition shadow-sm" placeholder="Enter your name">
                        @error('customerName') <span class="text-red-500 text-xs font-medium mt-1 inline-block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Phone (Optional)</label>
                        <input type="tel" wire:model="customerPhone" class="w-full rounded-xl bg-slate-50 border-transparent focus:border-brand-500 focus:bg-white focus:ring-0 text-slate-900 font-medium px-4 py-3 transition shadow-sm" placeholder="08123456789">
                        @error('customerPhone') <span class="text-red-500 text-xs font-medium mt-1 inline-block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- Receipt Card -->
            <div class="bg-white rounded-3xl p-1 shadow-xl shadow-slate-200/40 border border-slate-100">
                <div class="bg-slate-50 rounded-[22px] p-5 border border-slate-100 border-dashed">
                    <h3 class="font-bold text-lg text-slate-900 mb-4 flex items-center gap-2 border-b border-slate-200/60 pb-3 border-dashed">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Order Summary
                    </h3>
                    
                    @if(empty($cart))
                        <div class="text-center py-6">
                            <p class="text-sm text-slate-500 font-medium">Your cart is empty.</p>
                        </div>
                    @else
                        <ul class="space-y-4">
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php $sub = $item['price'] * $item['quantity']; $total += $sub; @endphp
                                <li class="flex justify-between items-start gap-4">
                                    <div class="flex items-start gap-3 flex-1">
                                        <div class="w-6 h-6 rounded bg-brand-100 text-brand-700 flex items-center justify-center font-bold text-xs flex-shrink-0 mt-0.5">
                                            {{ $item['quantity'] }}x
                                        </div>
                                        <div>
                                            <span class="font-semibold text-slate-900 leading-tight">{{ $item['name'] }}</span>
                                            @if(!empty($item['notes']))
                                                <p class="text-xs text-slate-500 mt-0.5 bg-white p-1 rounded inline-block">{{ $item['notes'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <span class="font-medium text-slate-900 flex-shrink-0">Rp {{ number_format($sub, 0, ',', '.') }}</span>
                                </li>
                            @endforeach
                        </ul>
                        
                        <div class="mt-6 pt-4 border-t border-slate-200/60 border-dashed">
                            <div class="flex justify-between items-end">
                                <span class="font-bold text-slate-500 uppercase tracking-wider text-sm">Total Payment</span>
                                <span class="font-extrabold text-2xl text-brand-600 tracking-tight">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Floating Action Button for Submit (Full width bottom style) -->
            <div class="fixed bottom-0 left-0 w-full z-50 p-4 pb-6 bg-gradient-to-t from-slate-50 via-slate-50 to-transparent">
                <div class="max-w-md mx-auto">
                    <button type="submit" class="w-full bg-brand-600 text-white rounded-2xl p-4 shadow-xl shadow-brand-500/30 hover:bg-brand-700 transition flex items-center justify-center gap-2 group transform active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                        <span wire:loading.remove class="font-bold text-lg">Confirm & Place Order</span>
                        <span wire:loading class="font-bold text-lg flex items-center gap-2">
                            <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Processing...
                        </span>
                        <svg wire:loading.remove class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
