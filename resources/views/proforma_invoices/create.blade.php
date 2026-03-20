@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Create Proforma Invoice</h2>
        </div>

        <form method="POST" action="{{ route('proforma-invoices.store') }}" class="bg-white rounded-lg shadow-sm p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">PI Number</label>
                    <input name="pi_number" value="{{ old('pi_number') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Link Sales Order (optional)</label>
                    <select name="sales_order_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="">Select sales order...</option>
                        @foreach($salesOrders as $so)
                            <option value="{{ $so->id }}" {{ old('sales_order_id') == $so->id ? 'selected' : '' }}>{{ $so->order_number ?? $so->so_number }} - {{ $so->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input name="customer_name" value="{{ old('customer_name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                    <input type="date" name="issue_date" value="{{ old('issue_date', now()->toDateString()) }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="draft">Draft</option>
                        <option value="issued">Issued</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                <input name="total_amount" type="number" step="0.01" value="{{ old('total_amount') }}" required
                    class="mt-1 block w-full md:w-1/2 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
            </div>

            <div class="mb-6 w-full">
                <label class="block text-sm font-medium text-gray-700">Notes / Remarks</label>
                <textarea name="notes" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200">
                <a href="{{ route('proforma-invoices.index') }}" class="px-4 py-2 bg-white text-gray-700 rounded-md hover:bg-gray-50 text-sm font-medium border border-gray-300 shadow-sm transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium border border-transparent shadow-sm transition-colors">
                    Create Proforma Invoice
                </button>
            </div>
        </form>
    </div>
@endsection
