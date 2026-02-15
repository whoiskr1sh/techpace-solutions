@extends('layouts.dashboard')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Create Sales Order</h2>

    <form method="POST" action="{{ route('sales-orders.store') }}" class="grid grid-cols-1 gap-4 max-w-xl">
        @csrf
        <div>
            <label class="block text-sm font-medium">SO Number</label>
            <input name="so_number" value="{{ old('so_number') }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            @error('so_number')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Quotation</label>
            <select name="quotation_id" class="mt-1 block w-full border rounded px-3 py-2" required>
                <option value="">Select quotation</option>
                @foreach($quotations as $q)
                    <option value="{{ $q->id }}" @selected(old('quotation_id') == $q->id)>{{ $q->quotation_number }} — {{ $q->customer_name }}</option>
                @endforeach
            </select>
            @error('quotation_id')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Total Amount</label>
            <input name="total_amount" type="number" step="0.01" value="{{ old('total_amount',0) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            @error('total_amount')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="dispatched">Dispatched</option>
                <option value="completed">Completed</option>
            </select>
            @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Create</button>
            <a href="{{ route('sales-orders.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>

@endsection
