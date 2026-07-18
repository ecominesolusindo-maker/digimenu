<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>{{ $title ?? 'Menu' }} - {{ $restaurant->name ?? 'RestoSaaS' }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Vite (Tailwind v4) -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: { sans: ['Outfit', 'sans-serif'] },
                            colors: { brand: { 50: '#eef2ff', 100: '#e0e7ff', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca' } }
                        }
                    }
                }
            </script>
        @endif
        
        <style>
            body { font-family: 'Outfit', sans-serif; -webkit-tap-highlight-color: transparent; }
            .glass-nav { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.6); }
            /* Hide scrollbar for clean app-like UI */
            ::-webkit-scrollbar { width: 0px; background: transparent; }
        </style>
        @livewireStyles
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased font-sans pb-24 selection:bg-brand-500 selection:text-white">
        
        <!-- Navbar -->
        <nav class="fixed top-0 w-full z-50 glass-nav shadow-sm">
            <div class="max-w-md mx-auto px-4">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600">
                            <!-- Shop Icon -->
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-lg leading-tight tracking-tight text-slate-900">{{ $restaurant->name ?? 'RestoSaaS' }}</span>
                            @if(isset($table))
                            <span class="text-xs font-medium text-brand-600">Table {{ $table->table_number }}</span>
                            @else
                            <span class="text-xs font-medium text-slate-500">Takeaway</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-md mx-auto px-4 pt-20">
            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-2xl mb-6 shadow-sm flex items-center gap-2" role="alert">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-medium text-sm">{{ session('success') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-2xl mb-6 shadow-sm flex items-center gap-2" role="alert">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="block sm:inline font-medium text-sm">{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
