<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $title ?? 'RestoSaaS Menu' }}</title>
        
        <!-- Tailwind CSS (CDN for rapid dev in Customer App) -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Alpine.js (usually handled by Livewire 3 automatically, but we can rely on Livewire) -->
        @livewireStyles
    </head>
    <body class="bg-gray-50 text-gray-800 antialiased font-sans">
        
        <!-- Navbar -->
        <nav class="bg-white shadow-sm sticky top-0 z-50">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <span class="font-bold text-xl text-orange-600">{{ $restaurant->name ?? 'RestoSaaS' }}</span>
                    </div>
                    @if(isset($table))
                    <div class="text-sm font-medium text-gray-500 bg-orange-50 px-3 py-1 rounded-full">
                        Table: {{ $table->table_number }}
                    </div>
                    @else
                    <div class="text-sm font-medium text-gray-500 bg-blue-50 px-3 py-1 rounded-full">
                        Takeaway/Delivery
                    </div>
                    @endif
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Flash Messages -->
            @if (session()->has('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>

        @livewireScripts
    </body>
</html>
