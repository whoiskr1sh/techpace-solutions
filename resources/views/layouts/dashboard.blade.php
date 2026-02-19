<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Techpace CRM — Dashboard</title>

    <!-- Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Global Styles */
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f1f5f9; /* Slate-100 */
            /* Very subtle mesh for depth */
            background-image: 
                radial-gradient(at 0% 0%, rgba(219, 234, 254, 0.5) 0px, transparent 50%), 
                radial-gradient(at 100% 0%, rgba(224, 231, 255, 0.5) 0px, transparent 50%);
            min-height: 100vh;
            color: #334155;
            background-attachment: fixed;
        }

        /* Glassmorphism Utility */
        .glass {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Sidebar Transition */
        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        /* Premium Card */
        .bg-white, .card {
            background: #ffffff;
            border: 1px solid #f1f5f9; /* Subtle border */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-radius: 12px; /* Smooth rounded corners */
        }

        /* Hover Effect - Elegant Lift */
        .hover-card {
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            border-color: #e2e8f0;
        }

        /* Button Hover Scale - Very Subtle */
        .btn-hover {
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .btn-hover:hover {
            transform: translateY(-1px);
            filter: brightness(105%);
        }

        .btn-hover:active {
            transform: translateY(0);
        }

        /* Form Inputs - Modern */
        input, select, textarea {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            transition: all 0.2s ease;
        }

        input:focus,
        select:focus,
        textarea:focus {
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15); /* Indigo glow */
            border-color: #6366f1;
            outline: none;
        }

        /* Sidebar Styling */
        aside {
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.02);
            border-right: 1px solid rgba(255, 255, 255, 0.5);
        }

        /* Tables */
        table thead tr th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.75rem;
        }

        table tbody tr {
            transition: background-color 0.2s;
        }
        
        table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* Simple Fade In on Load */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen text-gray-800 antialiased">
    <div id="app" class="flex h-screen overflow-hidden">
        {{-- Sidebar --}}
        <div class="relative z-30">
            @include('components.sidebar')
        </div>

        {{-- Main content area --}}
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50/50 backdrop-blur-sm">
            {{-- Topbar --}}
            <header class="glass sticky top-0 z-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center gap-3">
                            <button id="mobile-toggle"
                                class="md:hidden p-2 rounded bg-gray-50 hover:bg-gray-100 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1
                                class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                                Techpace Solutions</h1>
                        </div>
                        <div class="flex items-center gap-4">
                            {{-- Topbar actions moved to sidebar. --}}
                        </div>
                    </div>
                </div>
            </header>

            {{-- Content --}}
            <main class="flex-1 overflow-y-auto p-4 md:p-6 lg:p-8 w-full scroll-smooth fade-in">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script>
        const toggle = document.getElementById('mobile-toggle');
        const sidebar = document.getElementById('sidebar');
        // Simple sidebar toggle
        toggle?.addEventListener('click', () => {
            // Assuming sidebar component has logic or ID to toggle class. 
            // Ideally sidebar blade should have the ID 'sidebar' on the aside element.
            const aside = document.querySelector('aside');
            if (aside) aside.classList.toggle('-translate-x-full');
        });

        document.addEventListener('DOMContentLoaded', () => {
            // Add hover effects to cards automatically
            document.querySelectorAll('.bg-white.rounded-lg, .card').forEach(card => {
                card.classList.add('hover-card');
            });

            // Add hover effects to buttons automatically
            document.querySelectorAll('button, .btn').forEach(btn => {
                btn.classList.add('btn-hover');
            });
        });
    </script>
</body>

</html>