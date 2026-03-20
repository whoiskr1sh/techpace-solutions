@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-semibold">Duplicate Quotation Details</h2>
        </div>
        <div class="space-x-2">
            <a href="{{ route('duplicate-quotations.index') }}" class="px-3 py-2 border rounded hover:bg-gray-50 transition-colors">Back</a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Quotation References">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Original</span>
                        <span class="font-medium text-gray-900">{{ $dq->original->quotation_number ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Duplicate</span>
                        <span class="font-medium text-gray-900">{{ $dq->duplicate->quotation_number ?? '—' }}</span>
                    </div>
                </div>
            </x-card>

            @if($dq->reason)
            <x-card title="Reason for Duplication">
                <div class="text-sm text-gray-700 whitespace-pre-wrap mt-2">{{ $dq->reason }}</div>
            </x-card>
            @endif
        </div>
    </div>
@endsection
