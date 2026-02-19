<aside id="sidebar"
    class="w-64 bg-white border-r min-h-screen p-4 sidebar-transition transform md:translate-x-0 -translate-x-full md:static fixed z-40">
    <a href="{{ request()->fullUrl() }}" class="flex items-center gap-2 mb-6 hover:opacity-80 transition-opacity">
        <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center text-white font-bold">TP</div>
        <div>
            <div class="font-semibold">Techpace</div>
            <div class="text-xs text-gray-500">CRM</div>
        </div>
    </a>

    @php $role = auth()->user()?->role ?? 'guest'; @endphp

    <nav class="space-y-1">
        @php
            $activeClass = 'bg-blue-50 text-blue-700 border-r-4 border-blue-600';
            $inactiveClass = 'text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors';
        @endphp

        <a href="{{ route('dashboard') }}"
            class="block px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? $activeClass : $inactiveClass }}">
            Dashboard
        </a>

        {{-- Admin menu --}}
        @if($role === 'admin')
            <div class="px-4 pt-6 pb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Management</div>

            <a href="{{ route('quotations.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('quotations.*') ? $activeClass : $inactiveClass }}">Quotations</a>
            <a href="{{ route('sales-orders.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('sales-orders.*') ? $activeClass : $inactiveClass }}">Sales
                Orders</a>
            <a href="{{ route('invoices.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('invoices.*') ? $activeClass : $inactiveClass }}">Invoices</a>
            <a href="{{ route('vendors.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('vendors.*') ? $activeClass : $inactiveClass }}">Vendors</a>

            <div class="px-4 pt-4 pb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Logistics</div>
            <a href="{{ route('purchase-orders.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('purchase-orders.*') ? $activeClass : $inactiveClass }}">Purchase
                Orders</a>
            <a href="{{ route('couriers.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('couriers.*') ? $activeClass : $inactiveClass }}">Couriers</a>

            <div class="px-4 pt-4 pb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Settings</div>
            <a href="{{ route('hsn-codes.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('hsn-codes.*') ? $activeClass : $inactiveClass }}">HSN
                Codes</a>
            <a href="{{ route('duplicate-quotations.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('duplicate-quotations.*') ? $activeClass : $inactiveClass }}">Duplicate
                Quotes</a>

        @elseif($role === 'sales')
            <div class="px-4 pt-6 pb-2 text-xs font-bold text-slate-400 uppercase tracking-wider">Sales</div>
            <a href="{{ route('quotations.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('quotations.*') ? $activeClass : $inactiveClass }}">My
                Quotations</a>
            <a href="{{ route('quotations.create') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('quotations.create') ? $activeClass : $inactiveClass }}">Create
                Quotation</a>
            <a href="{{ route('sales-orders.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('sales-orders.*') ? $activeClass : $inactiveClass }}">Sales
                Orders</a>
            <a href="{{ route('proforma-invoices.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('proforma-invoices.*') ? $activeClass : $inactiveClass }}">Proforma
                Invoices</a>
            @if(App\Models\Setting::get('invoices_visible_for_sales', '1') === '1')
                <a href="{{ route('invoices.index') }}"
                    class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('invoices.*') ? $activeClass : $inactiveClass }}">Invoices</a>
            @endif
            <a href="{{ route('couriers.index') }}"
                class="block px-4 py-2.5 text-sm font-medium {{ request()->routeIs('couriers.*') ? $activeClass : $inactiveClass }}">Couriers</a>
        @endif

    </nav>

    <div class="mt-6 pt-4 border-t text-sm text-gray-600">
        <div>Signed in as</div>
        <div class="font-medium">{{ auth()->user()?->email }}</div>
        <div class="mt-2">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-red-600 hover:text-red-800">Logout</button>
            </form>
        </div>
    </div>
</aside>