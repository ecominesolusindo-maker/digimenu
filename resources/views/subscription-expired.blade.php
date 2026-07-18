<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Subscription Expired</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="bg-gray-100 h-screen flex items-center justify-center font-sans antialiased">
        <div class="max-w-md w-full bg-white shadow-lg rounded-xl p-8 text-center border-t-4 border-red-500">
            <svg class="w-16 h-16 text-red-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Access Denied</h1>
            
            @if(session('error'))
                <p class="text-gray-600 mb-6">{{ session('error') }}</p>
            @else
                <p class="text-gray-600 mb-6">Your subscription has expired. Please contact sales to renew your plan.</p>
            @endif

            <a href="/" class="inline-block bg-gray-900 text-white font-bold py-2 px-6 rounded-lg hover:bg-gray-800 transition">
                Return to Homepage
            </a>
            
            <form method="POST" action="/owner/logout" class="mt-4">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:underline">
                    Logout
                </button>
            </form>
        </div>
    </body>
</html>
