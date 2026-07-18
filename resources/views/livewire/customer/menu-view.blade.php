<div>
    <!-- Header Categories (Sticky/Horizontal scroll for modern app feel) -->
    <div class="sticky top-16 z-40 bg-slate-50/90 backdrop-blur-md py-4 -mx-4 px-4 shadow-sm border-b border-slate-200 overflow-x-auto no-scrollbar">
        <div class="flex gap-2">
            @foreach($categories as $category)
                <a href="#cat-{{ $category->id }}" class="whitespace-nowrap px-4 py-2 rounded-full font-medium text-sm transition-colors border {{ $loop->first ? 'bg-brand-600 text-white border-brand-600 shadow-md shadow-brand-500/20' : 'bg-white text-slate-600 border-slate-200 hover:bg-slate-100' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>

    <!-- Menu Categories & Items -->
    <div class="space-y-12 mt-6 pb-20">
        @forelse($categories as $category)
            <div id="cat-{{ $category->id }}" class="scroll-mt-36">
                <h2 class="text-2xl font-extrabold text-slate-900 mb-6 flex items-center gap-2">
                    {{ $category->name }}
                    <span class="text-sm font-medium text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full">{{ $category->menuItems->count() }}</span>
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    @forelse($category->menuItems as $item)
                        <div class="bg-white rounded-3xl p-3 border border-slate-100 shadow-xl shadow-slate-200/40 flex gap-4 transition duration-300 hover:shadow-2xl hover:-translate-y-1 group">
                            <!-- Image -->
                            <div class="w-32 h-32 flex-shrink-0 bg-slate-100 rounded-2xl overflow-hidden relative">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-slate-300">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 flex flex-col justify-between py-1">
                                <div>
                                    <h3 class="font-bold text-lg leading-tight text-slate-900 group-hover:text-brand-600 transition-colors">{{ $item->name }}</h3>
                                    <p class="text-sm text-slate-500 line-clamp-2 mt-1 leading-relaxed">{{ $item->description }}</p>
                                </div>
                                <div class="mt-3 flex justify-between items-end">
                                    <span class="font-extrabold text-brand-600 text-lg tracking-tight">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <!-- Add Button -->
                                    <button class="w-10 h-10 rounded-full bg-brand-50 text-brand-600 flex items-center justify-center hover:bg-brand-600 hover:text-white transition duration-200 shadow-sm active:scale-95" title="Add to cart">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-slate-500 italic text-sm">No items available in this category.</p>
                    @endforelse
                </div>
            </div>
        @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/40">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <p class="text-lg font-medium text-slate-600">No menu available yet.</p>
                <p class="text-slate-400 text-sm mt-1">Please check back later.</p>
            </div>
        @endforelse
    </div>

    <!-- Floating Action Button for Cart (Full width bottom style) -->
    <div class="fixed bottom-0 left-0 w-full z-50 p-4 pb-6 bg-gradient-to-t from-slate-50 via-slate-50 to-transparent">
        <div class="max-w-md mx-auto">
            <a href="#" class="w-full bg-brand-600 text-white rounded-2xl p-4 shadow-xl shadow-brand-500/30 hover:bg-brand-700 transition flex items-center justify-between group transform hover:-translate-y-1">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="absolute -top-1.5 -right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white border-2 border-brand-600 group-hover:border-brand-700 transition-colors">
                            0
                        </span>
                    </div>
                    <span class="font-semibold text-lg">View Cart</span>
                </div>
                <div class="font-bold text-lg">
                    Rp 0
                </div>
            </a>
        </div>
    </div>
</div>
