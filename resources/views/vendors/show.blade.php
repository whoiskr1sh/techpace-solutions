@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-semibold">Vendor: {{ $vendor->name }}</h2>
            <div class="text-sm text-gray-500">{{ $vendor->email ?? 'No email provided' }}</div>
        </div>
        <div class="space-x-2">
            <a href="{{ route('vendors.index') }}" class="px-3 py-2 border rounded hover:bg-gray-50 transition-colors">Back</a>
            <a href="{{ route('vendors.edit', $vendor) }}" class="px-3 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-colors">Edit</a>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="md:col-span-2 space-y-4">
            <x-card title="Vendor Details">
                <div class="grid grid-cols-2 gap-4 text-sm mt-4">
                    <div>
                        <span class="text-gray-500 block">Contact Person</span>
                        <span class="font-medium text-gray-900">{{ $vendor->contact_person ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Phone</span>
                        <span class="font-medium text-gray-900">{{ $vendor->phone ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">GSTIN</span>
                        <span class="font-medium text-gray-900">{{ $vendor->gstin ?? '—' }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500 block">Email</span>
                        <span class="font-medium text-gray-900">{{ $vendor->email ?? '—' }}</span>
                    </div>
                </div>
            </x-card>

            @if($vendor->address)
            <x-card title="Address">
                <div class="text-sm text-gray-700 whitespace-pre-wrap mt-2">{{ $vendor->address }}</div>
            </x-card>
            @endif
        </div>

        <div class="md:col-span-1 space-y-4">
            <x-card title="Metadata">
                <div class="text-sm space-y-4">
                    <div>
                        <span class="text-gray-500 block font-medium">Status</span>
                        <div class="mt-1">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $vendor->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($vendor->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
    </div>
@endsection
