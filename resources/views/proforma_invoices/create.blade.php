@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Create Proforma Invoice</h2>

    <form method="POST" action="{{ route('proforma-invoices.store') }}">
        @csrf
        <div class="grid gap-3 max-w-lg">
            <input name="pi_number" value="{{ old('pi_number') }}" placeholder="PI Number" class="input" required />

            <select name="sales_order_id" class="input">
                <option value="">Link Sales Order (optional)</option>
                @foreach($salesOrders as $so)
                    <option value="{{ $so->id }}" {{ old('sales_order_id') == $so->id ? 'selected' : '' }}>{{ $so->order_number }} - {{ $so->customer_name }}</option>
                @endforeach
            </select>

            <input name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer name" class="input" />
            <input type="date" name="issue_date" value="{{ old('issue_date', now()->toDateString()) }}" class="input" />
            <input name="total_amount" value="{{ old('total_amount') }}" placeholder="Total amount" class="input" required />

            <select name="status" class="input">
                <option value="draft">Draft</option>
                <option value="issued">Issued</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <textarea name="notes" placeholder="Notes" class="input">{{ old('notes') }}</textarea>

            <div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('proforma-invoices.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
