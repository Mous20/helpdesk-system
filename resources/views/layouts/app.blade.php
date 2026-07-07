<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Laravel') }} - HelpDesk</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    <div class="flex min-h-screen">
        
        <!-- Sidebar -->
        @auth
            @include('layouts.sidebar')
        @endauth

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Top Header -->
            <header class="bg-white shadow-sm sticky top-0 z-10">
                <div class="px-6 py-4">
                    @isset($header)
                        {{ $header }}
                    @else
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">
                                {{ ucfirst(request()->segment(1)) ?: 'Dashboard' }}
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ auth()->user()->role === 'admin' ? 'Administrator' : (auth()->user()->role === 'agent' ? 'Support Agent' : 'Customer') }} Panel
                            </p>
                        </div>
                    @endisset
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-3 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} HelpDesk System. All rights reserved.
            </footer>
        </div>
    </div>

    <!-- Alpine.js for dropdowns -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>