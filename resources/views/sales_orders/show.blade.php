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

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Order Details">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Quotation Reference</span>
                        <span class="font-medium text-gray-900">{{ $salesOrder->quotation?->quotation_number }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Customer Name</span>
                        <span class="font-medium text-gray-900">{{ $salesOrder->quotation?->customer_name }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Total Amount</span>
                        <span class="font-medium text-gray-900 font-semibold">{{ number_format($salesOrder->total_amount, 2) }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        <div class="md:col-span-1 space-y-4">
            <x-card title="Metadata">
                <div class="text-sm space-y-4">
                    <div>
                        <span class="text-gray-500 block font-medium">Status</span>
                        <div class="mt-1">
                            <x-status-badge status="{{ $salesOrder->status }}" />
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500 block font-medium">Created On</span>
                        <span class="font-medium text-gray-900">{{ $salesOrder->created_at->toDayDateTimeString() }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block font-medium">Created By</span>
                        <span class="font-medium text-gray-900">{{ $salesOrder->creator?->name }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

@endsection
