<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Techpace CRM — Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* small helpers for scrollbar and transitions */
        .sidebar-transition { transition: transform .2s ease; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen font-sans text-gray-800">
    <div id="app" class="flex">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main content area --}}
        <div class="flex-1 min-h-screen flex flex-col">
            {{-- Topbar --}}
            <header class="bg-white border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3">
                            <button id="mobile-toggle" class="md:hidden p-2 rounded bg-gray-50 hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            </button>
                            <h1 class="text-lg font-semibold">Techpace Solutions</h1>
                        </div>
                        <div class="flex items-center gap-4">
                            {{-- Topbar actions moved to sidebar. --}}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="p-4 md:p-6 lg:p-8 w-full">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        toggle?.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>
