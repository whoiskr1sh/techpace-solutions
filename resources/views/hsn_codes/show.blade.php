@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-semibold">HSN Code: {{ $hsn->code }}</h2>
            <div class="text-sm text-gray-500">GST Rate: {{ $hsn->gst_rate }}%</div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('hsn-codes.index') }}" class="px-3 py-2 border rounded hover:bg-gray-50 transition-colors">Back</a>
            @can('update', $hsn)
                <a href="{{ route('hsn-codes.edit', $hsn) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors">Edit</a>
            @endcan
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="HSN Details">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Code</span>
                        <span class="font-medium text-gray-900">{{ $hsn->code }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">GST Rate</span>
                        <span class="font-medium text-gray-900">{{ $hsn->gst_rate }}%</span>
                    </div>
                </div>
            </x-card>

            @if($hsn->description)
            <x-card title="Description">
                <div class="text-sm text-gray-700 whitespace-pre-wrap mt-2">{{ $hsn->description }}</div>
            </x-card>
            @endif
        </div>
    </div>
@endsection
