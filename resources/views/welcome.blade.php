<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RestoSaaS - Premium Restaurant Management</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
        
        <!-- Styles / Scripts -->
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
            body { font-family: 'Outfit', sans-serif; }
            .glass-nav { background: rgba(255, 255, 255, 0.8); backdrop-filter: blur(12px); border-bottom: 1px solid rgba(226, 232, 240, 0.5); }
            .hero-bg { background: radial-gradient(circle at top right, #eef2ff 0%, #ffffff 50%, #fafafa 100%); }
            .feature-card { transition: all 0.3s ease; }
            .feature-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); border-color: #e0e7ff; }
        </style>
    </head>
    <body class="bg-slate-50 text-slate-800 antialiased selection:bg-brand-500 selection:text-white">
        
        <!-- Navbar -->
        <nav class="fixed w-full z-50 glass-nav transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-brand-500/30">R</div>
                        <span class="font-bold text-2xl tracking-tight text-slate-900">RestoSaaS</span>
                    </div>
                    <div class="hidden md:flex space-x-8 items-center">
                        <a href="#features" class="text-slate-600 hover:text-brand-600 font-medium transition">Features</a>
                        <a href="#pricing" class="text-slate-600 hover:text-brand-600 font-medium transition">Pricing</a>
                        <a href="/admin" class="text-brand-600 font-semibold hover:text-brand-700 transition">Log in</a>
                        <a href="/admin/register" class="bg-brand-600 hover:bg-brand-700 text-white px-6 py-2.5 rounded-full font-medium transition shadow-md shadow-brand-500/20 transform hover:-translate-y-0.5">Get Started</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden hero-bg">
            <!-- Decorative blobs -->
            <div class="absolute top-20 right-0 -mr-20 w-72 h-72 bg-brand-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-40 left-0 -ml-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-brand-50 text-brand-700 font-medium text-sm mb-8 border border-brand-100 shadow-sm">
                    <span class="flex h-2 w-2 rounded-full bg-brand-500"></span>
                    Now with Real-time KDS & QR Ordering
                </div>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 tracking-tight mb-8 leading-tight">
                    Manage your restaurant <br class="hidden md:block" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-purple-600">the modern way</span>
                </h1>
                
                <p class="mt-4 text-xl text-slate-600 max-w-3xl mx-auto mb-10 leading-relaxed">
                    Everything you need to run your F&B business efficiently. From beautiful digital QR menus and self-ordering to intelligent kitchen displays and POS.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    <a href="/admin/register" class="w-full sm:w-auto bg-brand-600 hover:bg-brand-700 text-white px-8 py-4 rounded-full font-semibold text-lg transition shadow-xl shadow-brand-500/30 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        Start for free
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                    <a href="#demo" class="w-full sm:w-auto bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-8 py-4 rounded-full font-semibold text-lg transition shadow-sm flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path></svg>
                        Watch Demo
                    </a>
                </div>

                <!-- Dashboard Mockup Image/Div -->
                <div class="mt-20 relative mx-auto w-full max-w-5xl">
                    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-slate-50 z-10 h-full w-full pointer-events-none" style="bottom: 0; top: auto; height: 30%;"></div>
                    <div class="bg-white rounded-t-2xl shadow-2xl border border-slate-200 overflow-hidden transform perspective-1000 rotate-x-12 scale-95 origin-bottom">
                        <!-- Mockup Header -->
                        <div class="bg-slate-100 px-4 py-3 border-b border-slate-200 flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                        </div>
                        <!-- Mockup Body -->
                        <div class="aspect-video bg-slate-50 p-8 flex">
                            <!-- Sidebar -->
                            <div class="w-1/4 h-full bg-white rounded-xl border border-slate-200 p-4 hidden md:block shadow-sm">
                                <div class="w-full h-8 bg-slate-100 rounded mb-6"></div>
                                <div class="w-3/4 h-4 bg-slate-100 rounded mb-4"></div>
                                <div class="w-1/2 h-4 bg-brand-50 rounded mb-4"></div>
                                <div class="w-2/3 h-4 bg-slate-100 rounded mb-4"></div>
                            </div>
                            <!-- Main Content -->
                            <div class="flex-1 md:ml-6 flex flex-col gap-6">
                                <div class="flex gap-4">
                                    <div class="flex-1 h-32 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                                        <div class="w-12 h-12 bg-green-50 rounded-lg mb-4"></div>
                                        <div class="w-1/2 h-4 bg-slate-100 rounded"></div>
                                    </div>
                                    <div class="flex-1 h-32 bg-white rounded-xl border border-slate-200 p-6 shadow-sm">
                                        <div class="w-12 h-12 bg-brand-50 rounded-lg mb-4"></div>
                                        <div class="w-1/2 h-4 bg-slate-100 rounded"></div>
                                    </div>
                                    <div class="flex-1 h-32 bg-white rounded-xl border border-slate-200 p-6 shadow-sm hidden lg:block">
                                        <div class="w-12 h-12 bg-orange-50 rounded-lg mb-4"></div>
                                        <div class="w-1/2 h-4 bg-slate-100 rounded"></div>
                                    </div>
                                </div>
                                <div class="flex-1 bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                                    <div class="w-full h-48 bg-slate-50 rounded-lg border border-slate-100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-24 bg-white relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-16">
                    <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm">Everything you need</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-slate-900 sm:text-4xl">
                        A complete ecosystem for your restaurant
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="feature-card bg-white p-8 rounded-2xl border border-slate-100 shadow-lg shadow-slate-100">
                        <div class="w-14 h-14 bg-brand-50 rounded-xl flex items-center justify-center text-brand-600 mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Interactive QR Menu</h3>
                        <p class="text-slate-500 leading-relaxed">Let your customers scan, browse, and order directly from their tables. Beautifully designed for mobile.</p>
                    </div>
                    
                    <!-- Feature 2 -->
                    <div class="feature-card bg-white p-8 rounded-2xl border border-slate-100 shadow-lg shadow-slate-100">
                        <div class="w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Smart Point of Sale</h3>
                        <p class="text-slate-500 leading-relaxed">A lightning-fast POS interface for your cashiers. Handle orders, payments, and splits with zero friction.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card bg-white p-8 rounded-2xl border border-slate-100 shadow-lg shadow-slate-100">
                        <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-6">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-3">Real-time KDS</h3>
                        <p class="text-slate-500 leading-relaxed">Send orders directly to the kitchen. Chefs see what to prepare instantly, reducing errors and wait times.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-brand-900 relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center relative z-10">
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-6">Ready to transform your restaurant?</h2>
                <p class="text-xl text-brand-100 mb-10 max-w-2xl mx-auto">Join hundreds of modern restaurants using RestoSaaS to streamline operations and boost sales.</p>
                <a href="/admin/register" class="inline-flex items-center justify-center bg-white text-brand-900 font-bold px-8 py-4 rounded-full text-lg shadow-lg hover:bg-brand-50 transition transform hover:scale-105">
                    Start Your Free Trial
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-slate-50 border-t border-slate-200 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 bg-brand-600 rounded-lg flex items-center justify-center text-white font-bold text-sm">R</div>
                    <span class="font-bold text-xl text-slate-900">RestoSaaS</span>
                </div>
                <p class="text-slate-500 text-sm">© {{ date('Y') }} RestoSaaS Platform. All rights reserved.</p>
            </div>
        </footer>

    </body>
</html>
