@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Purchase Orders</h2>
        <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary">New PO</a>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-center">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search PO#" class="input" />
        <select name="vendor_id" class="input">
            <option value="">All Vendors</option>
            @foreach($vendors as $v)
                <option value="{{ $v->id }}" {{ request('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
            @endforeach
        </select>
        <select name="status" class="input">
            <option value="">All Statuses</option>
            <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
            <option value="ordered" {{ request('status')=='ordered' ? 'selected' : '' }}>Ordered</option>
            <option value="received" {{ request('status')=='received' ? 'selected' : '' }}>Received</option>
            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button class="btn">Filter</button>
    </form>

    <div class="grid gap-4">
        @foreach($pos as $po)
            <div class="card">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $po->po_number }}</h3>
                        <div class="text-sm text-gray-600">{{ $po->vendor->name ?? '—' }} • {{ $po->order_date->format('Y-m-d') }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm">View</a>
                        @can('update', $po)
                            <a href="{{ route('purchase-orders.edit', $po) }}" class="btn btn-sm">Edit</a>
                        @endcan
                        @can('delete', $po)
                            <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete PO?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $pos->links() }}</div>
</div>
@endsection
