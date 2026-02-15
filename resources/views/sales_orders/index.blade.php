@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Sales Orders</h2>
    <div class="flex items-center gap-2">
        @can('create', App\Models\SalesOrder::class)
            <a href="{{ route('sales-orders.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New SO</a>
        @endcan
    </div>
</div>

<form method="GET" action="{{ route('sales-orders.index') }}" class="mb-4 flex gap-2 items-end">
    <div>
        <label class="text-xs">Search</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search" class="border rounded px-2 py-1 text-sm">
    </div>
    <div>
        <label class="text-xs">Status</label>
        <select name="status" class="border rounded px-2 py-1 text-sm">
            <option value="">All</option>
            <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ request('status')=='confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="dispatched" {{ request('status')=='dispatched' ? 'selected' : '' }}>Dispatched</option>
            <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed</option>
        </select>
    </div>
    <div>
        <label class="text-xs">User</label>
        <select name="user_id" class="border rounded px-2 py-1 text-sm">
            <option value="">Any</option>
            @foreach($users as $u)
                <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="text-xs">From</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded px-2 py-1 text-sm" />
    </div>
    <div>
        <label class="text-xs">To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded px-2 py-1 text-sm" />
    </div>
    <div class="flex gap-2">
        <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        <a href="{{ route('sales-orders.index', array_merge(request()->all(), ['export'=>'csv'])) }}" class="px-3 py-1 bg-green-600 text-white rounded">Export CSV</a>
        <a href="{{ route('sales-orders.index', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Export PDF</a>
    </div>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs text-left text-gray-600">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Quotation</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Created By</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesOrders as $so)
            <tr class="border-t">
                <td class="p-3">{{ $so->so_number }}</td>
                <td class="p-3">{{ $so->quotation?->quotation_number }}<div class="text-xs text-gray-500">{{ $so->quotation?->customer_name }}</div></td>
                <td class="p-3">{{ number_format($so->total_amount,2) }}</td>
                <td class="p-3"><x-status-badge status="{{ $so->status }}" /></td>
                <td class="p-3">{{ $so->creator?->name }}</td>
                <td class="p-3">
                    <div class="flex items-center gap-2">
                        @can('view', $so)
                        <a href="{{ route('sales-orders.show', $so) }}" class="text-blue-600">View</a>
                        @endcan
                        @can('update', $so)
                        <a href="{{ route('sales-orders.edit', $so) }}" class="text-yellow-600">Edit</a>
                        @endcan
                        @can('delete', $so)
                        <form method="POST" action="{{ route('sales-orders.destroy', $so) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600">Delete</button></form>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $salesOrders->links() }}</div>

@endsection
