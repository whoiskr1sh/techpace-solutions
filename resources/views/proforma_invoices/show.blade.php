@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold">Proforma Invoice {{ $pi->pi_number }}</h2>
            <div class="text-sm text-gray-500">{{ $pi->customer_name ?? 'Unknown Customer' }}</div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('proforma-invoices.index') }}" class="px-3 py-2 border rounded hover:bg-gray-50 transition-colors">Back</a>
            <a href="{{ route('proforma-invoices.edit', $pi) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors">Edit</a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Invoice Details">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Customer</span>
                        <span class="font-medium text-gray-900">{{ $pi->customer_name ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Linked Sales Order</span>
                        <span class="font-medium text-gray-900">{{ $pi->salesOrder->order_number ?? $pi->salesOrder->so_number ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Total Amount</span>
                        <span class="font-medium text-gray-900 font-semibold">{{ number_format($pi->total_amount, 2) }}</span>
                    </div>
                </div>
            </x-card>

            @if($pi->notes)
            <x-card title="Notes / Remarks">
                <div class="text-sm text-gray-700 whitespace-pre-wrap mt-2">{{ $pi->notes }}</div>
            </x-card>
            @endif
        </div>

        <div class="md:col-span-1 space-y-4">
            <x-card title="Metadata">
                <div class="text-sm space-y-4">
                    <div>
                        <span class="text-gray-500 block font-medium">Status</span>
                        <div class="mt-1">
                            <x-status-badge status="{{ $pi->status }}" />
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500 block font-medium">Issue Date</span>
                        <span class="font-medium text-gray-900">{{ optional($pi->issue_date)->format('M d, Y') ?? '—' }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection
