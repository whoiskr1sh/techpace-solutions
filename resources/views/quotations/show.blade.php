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
            <form method="POST" action="{{ route('quotations.destroy', $quotation) }}" onsubmit="return confirm('Delete?')" class="inline">@csrf @method('DELETE')<button class="px-3 py-2 bg-red-600 text-white rounded">Delete</button></form>
            @endcan
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-card title="Details">
            <div class="text-sm">
                <div><strong>Customer:</strong> {{ $quotation->customer_name }}</div>
                <div><strong>Email:</strong> {{ $quotation->customer_email }}</div>
                <div><strong>Phone:</strong> {{ $quotation->customer_phone }}</div>
                <div class="mt-2"><strong>Notes:</strong><div class="text-xs text-gray-600">{{ $quotation->notes }}</div></div>
            </div>
        </x-card>

        <x-card title="Meta">
            <div class="text-sm">
                <div><strong>Total:</strong> {{ number_format($quotation->total_amount,2) }}</div>
                <div class="mt-2"><strong>Status:</strong> <x-status-badge status="{{ $quotation->status }}" /></div>
                <div class="mt-2"><strong>Created:</strong> {{ $quotation->created_at->toDayDateTimeString() }}</div>
                <div class="mt-2"><strong>Created by:</strong> {{ $quotation->creator?->name }}</div>
            </div>
        </x-card>
    </div>

@endsection
