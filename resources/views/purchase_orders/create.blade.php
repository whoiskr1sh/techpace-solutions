@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Create Purchase Order</h2>

    <form method="POST" action="{{ route('purchase-orders.store') }}">
        @csrf
        <div class="grid gap-3 max-w-lg">
            <input name="po_number" value="{{ old('po_number') }}" placeholder="PO Number" class="input" required />

            <select name="vendor_id" class="input" required>
                <option value="">Select vendor</option>
                @foreach($vendors as $v)
                    <option value="{{ $v->id }}" {{ old('vendor_id') == $v->id ? 'selected' : '' }}>{{ $v->name }}</option>
                @endforeach
            </select>

            <select name="sales_order_id" class="input">
                <option value="">Link Sales Order (optional)</option>
                @foreach($salesOrders as $so)
                    <option value="{{ $so->id }}" {{ old('sales_order_id') == $so->id ? 'selected' : '' }}>{{ $so->order_number }} - {{ $so->customer_name }}</option>
                @endforeach
            </select>

            <input type="date" name="order_date" value="{{ old('order_date', now()->toDateString()) }}" class="input" required />
            <input type="date" name="expected_date" value="{{ old('expected_date') }}" class="input" />
            <input name="total_amount" value="{{ old('total_amount') }}" placeholder="Total amount" class="input" required />

            <select name="status" class="input">
                <option value="draft">Draft</option>
                <option value="ordered">Ordered</option>
                <option value="received">Received</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <textarea name="notes" placeholder="Notes" class="input">{{ old('notes') }}</textarea>

            <div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('purchase-orders.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
