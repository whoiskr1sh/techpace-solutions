@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Purchase Orders</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('purchase-orders.create') }}"
                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New PO</a>
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search PO#"
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <label class="text-xs">Vendor</label>
            <select name="vendor_id" class="border rounded px-2 py-1 text-sm">
                <option value="">All Vendors</option>
                @foreach($vendors as $v)
                    <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs">Status</label>
            <select name="status" class="border rounded px-2 py-1 text-sm">
                <option value="">All Statuses</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="ordered" {{ request('status') == 'ordered' ? 'selected' : '' }}>Ordered</option>
                <option value="received" {{ request('status') == 'received' ? 'selected' : '' }}>Received</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">PO #</th>
                    <th class="p-3">Vendor</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pos as $po)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $po->po_number }}</td>
                        <td class="p-3">{{ $po->vendor->name ?? '—' }}</td>
                        <td class="p-3">{{ $po->order_date->format('Y-m-d') }}</td>
                        <td class="p-3"><x-status-badge status="{{ $po->status }}" /></td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('purchase-orders.show', $po) }}" class="text-blue-600">View</a>
                                @can('update', $po)
                                    <a href="{{ route('purchase-orders.edit', $po) }}" class="text-yellow-600">Edit</a>
                                @endcan
                                @can('delete', $po)
                                    <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete PO?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $pos->links() }}</div>
@endsection