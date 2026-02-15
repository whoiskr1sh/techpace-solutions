@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold">{{ $pi->pi_number }}</h2>

    <div class="mt-4 grid gap-2 max-w-lg">
        <div><strong>Customer:</strong> {{ $pi->customer_name }}</div>
        <div><strong>Sales Order:</strong> {{ $pi->salesOrder->order_number ?? '—' }}</div>
        <div><strong>Issue Date:</strong> {{ optional($pi->issue_date)->format('Y-m-d') }}</div>
        <div><strong>Total:</strong> {{ number_format($pi->total_amount,2) }}</div>
        <div><strong>Status:</strong> {{ ucfirst($pi->status) }}</div>
        <div><strong>Notes:</strong> <pre class="whitespace-pre-wrap">{{ $pi->notes }}</pre></div>
    </div>

    <div class="mt-4">
        <a href="{{ route('proforma-invoices.index') }}" class="btn">Back</a>
    </div>
</div>
@endsection
