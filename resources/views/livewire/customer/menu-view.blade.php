<div>
    <!-- Menu Categories & Items -->
    <div class="space-y-8">
        @forelse($categories as $category)
            <div>
                <h2 class="text-2xl font-bold text-gray-800 border-b border-orange-200 pb-2 mb-4">{{ $category->name }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($category->menuItems as $item)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex hover:shadow-md transition duration-200">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-1/3 object-cover">
                            @else
                                <div class="w-1/3 bg-gray-100 flex items-center justify-center text-gray-400">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            <div class="p-4 w-2/3 flex flex-col justify-between">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900">{{ $item->name }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-2 mt-1">{{ $item->description }}</p>
                                </div>
                                <div class="mt-4 flex justify-between items-center">
                                    <span class="font-bold text-orange-600">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <button class="bg-orange-100 text-orange-600 hover:bg-orange-500 hover:text-white rounded-full p-2 transition duration-200" title="Add to cart (coming soon)">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 italic">No items available in this category.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-12">
                <p class="text-xl text-gray-500">Sorry, this restaurant hasn't added any menu yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Floating Action Button for Cart (Placeholder for real Cart logic) -->
    <div class="fixed bottom-6 right-6 z-50">
        <a href="#" class="bg-orange-600 text-white rounded-full p-4 shadow-lg hover:bg-orange-700 hover:shadow-xl transition flex items-center justify-center relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            <!-- Badge -->
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">
                0
            </span>
        </a>
    </div>
</div>
