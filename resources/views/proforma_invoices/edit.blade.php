@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Edit Proforma Invoice</h2>

    <form method="POST" action="{{ route('proforma-invoices.update', $proforma_invoice) }}">
        @csrf
        @method('PUT')
        <div class="grid gap-3 max-w-lg">
            <input name="pi_number" value="{{ old('pi_number', $proforma_invoice->pi_number) }}" placeholder="PI Number" class="input" required />

            <select name="sales_order_id" class="input">
                <option value="">Link Sales Order (optional)</option>
                @foreach($salesOrders as $so)
                    <option value="{{ $so->id }}" {{ old('sales_order_id', $proforma_invoice->sales_order_id) == $so->id ? 'selected' : '' }}>{{ $so->order_number }} - {{ $so->customer_name }}</option>
                @endforeach
            </select>

            <input name="customer_name" value="{{ old('customer_name', $proforma_invoice->customer_name) }}" placeholder="Customer name" class="input" />
            <input type="date" name="issue_date" value="{{ old('issue_date', optional($proforma_invoice->issue_date)->toDateString()) }}" class="input" />
            <input name="total_amount" value="{{ old('total_amount', $proforma_invoice->total_amount) }}" placeholder="Total amount" class="input" required />

            <select name="status" class="input">
                <option value="draft" {{ $proforma_invoice->status=='draft' ? 'selected' : '' }}>Draft</option>
                <option value="issued" {{ $proforma_invoice->status=='issued' ? 'selected' : '' }}>Issued</option>
                <option value="cancelled" {{ $proforma_invoice->status=='cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <textarea name="notes" placeholder="Notes" class="input">{{ old('notes', $proforma_invoice->notes) }}</textarea>

            <div>
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('proforma-invoices.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
