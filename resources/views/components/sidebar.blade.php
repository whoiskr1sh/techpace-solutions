<aside id="sidebar" class="w-64 bg-white border-r min-h-screen p-4 sidebar-transition transform md:translate-x-0 -translate-x-full md:static fixed z-40">
    <div class="flex items-center gap-2 mb-6">
        <div class="w-10 h-10 bg-red-600 rounded flex items-center justify-center text-white font-bold">TP</div>
        <div>
            <div class="font-semibold">Techpace</div>
            <div class="text-xs text-gray-500">CRM</div>
        </div>
    </div>

    @php $role = auth()->user()?->role ?? 'guest'; @endphp

    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Dashboard</a>

        {{-- Admin menu --}}
        @if($role === 'admin')
            <div class="pt-4 text-xs font-semibold text-gray-500 uppercase">Admin</div>
            <a href="{{ route('quotations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Quotations</a>
            <a href="{{ route('sales-orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Sales Orders</a>
            <a href="{{ route('vendors.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Vendors</a>
            <a href="{{ route('purchase-orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Purchase Orders</a>
            <a href="{{ route('proforma-invoices.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Proforma Invoices</a>
            <a href="{{ route('invoices.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Invoices</a>
            <a href="{{ route('couriers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Couriers</a>
            <a href="{{ route('hsn-codes.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">HSN Codes</a>
            <a href="{{ route('duplicate-quotations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Duplicate Quotations</a>
        @elseif($role === 'sales')
            <div class="pt-4 text-xs font-semibold text-gray-500 uppercase">Sales</div>
            <a href="{{ route('quotations.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">My Quotations</a>
            <a href="{{ route('quotations.create') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Create Quotation</a>
            <a href="{{ route('sales-orders.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Sales Orders</a>
            <a href="{{ route('proforma-invoices.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Proforma Invoices</a>
            @if(App\Models\Setting::get('invoices_visible_for_sales','1') === '1')
                <a href="{{ route('invoices.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Invoices</a>
            @endif
            <a href="{{ route('couriers.index') }}" class="block px-3 py-2 rounded hover:bg-gray-100">Couriers</a>
        @else
            <a href="#" class="block px-3 py-2 rounded hover:bg-gray-100">Public</a>
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
