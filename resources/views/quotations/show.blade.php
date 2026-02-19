@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold">Quotation {{ $quotation->quotation_number }}</h2>
            <div class="text-sm text-gray-500">{{ $quotation->customer_name }} — {{ $quotation->customer_email }}</div>
        </div>
        <div class="space-x-2">
            @can('update', $quotation)
                <a href="{{ route('quotations.edit', $quotation) }}" class="px-3 py-2 bg-yellow-500 text-white rounded">Edit</a>
            @endcan
            @can('delete', $quotation)
                <form method="POST" action="{{ route('quotations.destroy', $quotation) }}" onsubmit="return confirm('Delete?')"
                    class="inline">@csrf @method('DELETE')<button
                        class="px-3 py-2 bg-red-600 text-white rounded">Delete</button></form>
            @endcan
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Line Items">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Make</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Model</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Disc%</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Qty</th>
                                <th class="px-3 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($quotation->items as $item)
                                <tr>
                                    <td class="px-3 py-2 text-sm">{{ $item->make }}</td>
                                    <td class="px-3 py-2 text-sm">{{ $item->model_no }}</td>
                                    <td class="px-3 py-2 text-sm text-right">{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-3 py-2 text-sm text-right">{{ $item->discount }}%</td>
                                    <td class="px-3 py-2 text-sm text-right">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2 text-sm text-right">{{ number_format($item->total_price, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="px-3 py-2 text-right font-bold">Grand Total
                                    ({{ $quotation->currency }}):</td>
                                <td class="px-3 py-2 text-right font-bold">{{ number_format($quotation->total_amount, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-card>

            <x-card title="Notes">
                <div class="text-sm text-gray-700 whitespace-pre-wrap">{{ $quotation->notes }}</div>
            </x-card>
        </div>

        <div class="md:col-span-1 space-y-4">
            <x-card title="Customer Details">
                <div class="text-sm space-y-2">
                    <div><strong>Name:</strong> {{ $quotation->customer_name }}</div>
                    <div><strong>Email:</strong> {{ $quotation->customer_email }}</div>
                    <div><strong>Phone:</strong> {{ $quotation->customer_phone }}</div>
                    <div><strong>Source:</strong> {{ $quotation->source?->name ?? 'N/A' }}</div>
                </div>
            </x-card>

            <x-card title="Meta">
                <div class="text-sm space-y-2">
                    <div><strong>Status:</strong> <x-status-badge status="{{ $quotation->status }}" /></div>
                    <div><strong>Created:</strong> {{ $quotation->created_at->toDayDateTimeString() }}</div>
                    <div><strong>Created by:</strong> {{ $quotation->creator?->name }}</div>
                </div>
            </x-card>
        </div>
    </div>

@endsection