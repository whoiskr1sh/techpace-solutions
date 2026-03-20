@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold">{{ $po->po_number }}</h2>

    <div class="mt-4 grid gap-2 max-w-lg">
        <div><strong>Vendor:</strong> {{ $po->vendor->name ?? '—' }}</div>
        <div><strong>Sales Order:</strong> {{ $po->salesOrder->order_number ?? '—' }}</div>
        <div><strong>Order Date:</strong> {{ $po->order_date->format('Y-m-d') }}</div>
        <div><strong>Expected Date:</strong> {{ optional($po->expected_date)->format('Y-m-d') }}</div>
        <div><strong>Total:</strong> {{ number_format($po->total_amount,2) }}</div>
        <div><strong>Status:</strong> {{ ucfirst($po->status) }}</div>
        <div><strong>Notes:</strong> <pre class="whitespace-pre-wrap">{{ $po->notes }}</pre></div>
    </div>

    <div class="mt-4">
        <a href="{{ route('purchase-orders.index') }}" class="btn">Back</a>
        <a href="{{ route('purchase-orders.pdf', $po) }}" target="_blank" class="px-3 py-2 bg-gray-600 text-white rounded ml-2">Download PDF</a>
    </div>
</div>
@endsection
