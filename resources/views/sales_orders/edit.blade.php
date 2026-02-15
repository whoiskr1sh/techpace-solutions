@extends('layouts.dashboard')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Edit Sales Order</h2>

    <form method="POST" action="{{ route('sales-orders.update', $salesOrder) }}" class="grid grid-cols-1 gap-4 max-w-xl">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium">SO Number</label>
            <input value="{{ $salesOrder->so_number }}" class="mt-1 block w-full border rounded px-3 py-2" disabled>
        </div>

        <div>
            <label class="block text-sm font-medium">Total Amount</label>
            <input name="total_amount" type="number" step="0.01" value="{{ old('total_amount', $salesOrder->total_amount) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            @error('total_amount')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                <option value="pending" @selected(old('status', $salesOrder->status) == 'pending')>Pending</option>
                <option value="confirmed" @selected(old('status', $salesOrder->status) == 'confirmed')>Confirmed</option>
                <option value="dispatched" @selected(old('status', $salesOrder->status) == 'dispatched')>Dispatched</option>
                <option value="completed" @selected(old('status', $salesOrder->status) == 'completed')>Completed</option>
            </select>
            @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            <a href="{{ route('sales-orders.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>

@endsection
