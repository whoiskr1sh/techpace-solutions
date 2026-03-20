@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Create Sales Order</h2>
        </div>

        <form method="POST" action="{{ route('sales-orders.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">SO Number</label>
                    <input name="so_number" value="{{ old('so_number') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                    @error('so_number')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Quotation</label>
                    <select name="quotation_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="">Select quotation</option>
                        @foreach($quotations as $q)
                            <option value="{{ $q->id }}" @selected(old('quotation_id') == $q->id)>{{ $q->quotation_number }} — {{ $q->customer_name }}</option>
                        @endforeach
                    </select>
                    @error('quotation_id')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="dispatched">Dispatched</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                <input name="total_amount" type="number" step="0.01" value="{{ old('total_amount', 0) }}" required
                    class="mt-1 block w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                @error('total_amount')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('sales-orders.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium border border-gray-300 shadow-sm transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium border border-transparent shadow-sm transition-colors">
                    Create Sales Order
                </button>
            </div>
        </form>
    </div>
