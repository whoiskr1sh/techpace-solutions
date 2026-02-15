@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Create Invoice</h2>

    <form method="POST" action="{{ route('invoices.store') }}">
        @csrf
        <div class="grid gap-3 max-w-lg">
            <input name="invoice_number" value="{{ old('invoice_number') }}" placeholder="Invoice Number" class="input" required />

            <select name="proforma_invoice_id" class="input">
                <option value="">Link Proforma Invoice (optional)</option>
            </select>

            <select name="sales_order_id" class="input">
                <option value="">Link Sales Order (optional)</option>
                @foreach($salesOrders as $so)
                    <option value="{{ $so->id }}" {{ old('sales_order_id') == $so->id ? 'selected' : '' }}>{{ $so->order_number }} - {{ $so->customer_name }}</option>
                @endforeach
            </select>

            <input name="customer_name" value="{{ old('customer_name') }}" placeholder="Customer name" class="input" />
            <input type="date" name="issue_date" value="{{ old('issue_date', now()->toDateString()) }}" class="input" />
            <input type="date" name="due_date" value="{{ old('due_date') }}" class="input" />
            <input name="total_amount" value="{{ old('total_amount') }}" placeholder="Total amount" class="input" required />

            <select name="status" class="input">
                <option value="draft">Draft</option>
                <option value="issued">Issued</option>
                <option value="paid">Paid</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <textarea name="notes" placeholder="Notes" class="input">{{ old('notes') }}</textarea>

            <div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('invoices.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
