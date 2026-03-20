@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold">Sales Order {{ $salesOrder->so_number }}</h2>
            <div class="text-sm text-gray-500">Linked Quotation: {{ $salesOrder->quotation?->quotation_number }}</div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('sales-orders.pdf', $salesOrder) }}" target="_blank" class="px-3 py-2 bg-gray-600 text-white rounded">Download PDF</a>
            @can('update', $salesOrder)
            <a href="{{ route('sales-orders.edit', $salesOrder) }}" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
            @endcan
            @can('delete', $salesOrder)
            <form method="POST" action="{{ route('sales-orders.destroy', $salesOrder) }}" onsubmit="return confirm('Delete?')" class="inline">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-600 text-white rounded">Delete</button></form>
            @endcan
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-card title="Details">
            <div class="text-sm">
                <div><strong>Quotation:</strong> {{ $salesOrder->quotation?->quotation_number }}</div>
                <div><strong>Customer:</strong> {{ $salesOrder->quotation?->customer_name }}</div>
            </div>
        </x-card>

        <x-card title="Meta">
            <div class="text-sm">
                <div><strong>Total:</strong> {{ number_format($salesOrder->total_amount,2) }}</div>
                <div class="mt-2"><strong>Status:</strong> <x-status-badge status="{{ $salesOrder->status }}" /></div>
                <div class="mt-2"><strong>Created:</strong> {{ $salesOrder->created_at->toDayDateTimeString() }}</div>
                <div class="mt-2"><strong>Created by:</strong> {{ $salesOrder->creator?->name }}</div>
            </div>
        </x-card>
    </div>

@endsection
