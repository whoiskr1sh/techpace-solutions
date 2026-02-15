@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold">{{ $invoice->invoice_number }}</h2>

    <div class="mt-4 grid gap-2 max-w-lg">
        <div><strong>Customer:</strong> {{ $invoice->customer_name }}</div>
        <div><strong>Proforma:</strong> {{ $invoice->proformaInvoice->pi_number ?? '—' }}</div>
        <div><strong>Sales Order:</strong> {{ $invoice->salesOrder->order_number ?? '—' }}</div>
        <div><strong>Issue Date:</strong> {{ optional($invoice->issue_date)->format('Y-m-d') }}</div>
        <div><strong>Due Date:</strong> {{ optional($invoice->due_date)->format('Y-m-d') }}</div>
        <div><strong>Total:</strong> {{ number_format($invoice->total_amount,2) }}</div>
        <div><strong>Status:</strong> {{ ucfirst($invoice->status) }}</div>
        <div><strong>Notes:</strong> <pre class="whitespace-pre-wrap">{{ $invoice->notes }}</pre></div>
    </div>

    <div class="mt-4">
        <a href="{{ route('invoices.index') }}" class="btn">Back</a>
    </div>
</div>
@endsection
