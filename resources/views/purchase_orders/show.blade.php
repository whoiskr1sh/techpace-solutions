@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold">Purchase Order {{ $po->po_number }}</h2>
            <div class="text-sm text-gray-500">{{ $po->vendor?->name ?? 'Unknown Vendor' }}</div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('purchase-orders.index') }}" class="px-3 py-2 border rounded hover:bg-gray-50 transition-colors">Back</a>
            <a href="{{ route('purchase-orders.pdf', $po) }}" target="_blank" class="px-3 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors">Download PDF</a>
            <a href="{{ route('purchase-orders.edit', $po) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors">Edit</a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Order Details">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Vendor</span>
                        <span class="font-medium text-gray-900">{{ $po->vendor?->name ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Linked Sales Order</span>
                        <span class="font-medium text-gray-900">{{ $po->salesOrder?->order_number ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Total Amount</span>
                        <span class="font-medium text-gray-900 font-semibold">{{ number_format($po->total_amount, 2) }}</span>
                    </div>
                </div>
            </x-card>

            @if($po->notes)
            <x-card title="Notes / Remarks">
                <div class="text-sm text-gray-700 whitespace-pre-wrap mt-2">{{ $po->notes }}</div>
            </x-card>
            @endif
        </div>

        <div class="md:col-span-1 space-y-4">
            <x-card title="Metadata">
                <div class="text-sm space-y-4">
                    <div>
                        <span class="text-gray-500 block font-medium">Status</span>
                        <div class="mt-1">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($po->status) }}
                            </span>
                        </div>
                    </div>
                    <div>
                        <span class="text-gray-500 block font-medium">Order Date</span>
                        <span class="font-medium text-gray-900">{{ $po->order_date->format('M d, Y') }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block font-medium">Expected Date</span>
                        <span class="font-medium text-gray-900">{{ optional($po->expected_date)->format('M d, Y') ?? 'Not Set' }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection
