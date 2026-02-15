@extends('layouts.dashboard')

@section('content')
    <h2 class="text-xl font-semibold mb-4">Edit Quotation</h2>

    <form method="POST" action="{{ route('quotations.update', $quotation) }}" class="grid grid-cols-1 gap-4 max-w-xl">
        @csrf @method('PUT')
        <div>
            <label class="block text-sm font-medium">Quotation Number</label>
            <input name="quotation_number" value="{{ $quotation->quotation_number }}" class="mt-1 block w-full border rounded px-3 py-2" disabled>
        </div>
        <div>
            <label class="block text-sm font-medium">Customer Name</label>
            <input name="customer_name" value="{{ old('customer_name', $quotation->customer_name) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            @error('customer_name')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Customer Email</label>
            <input name="customer_email" value="{{ old('customer_email', $quotation->customer_email) }}" class="mt-1 block w-full border rounded px-3 py-2">
            @error('customer_email')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Total Amount</label>
            <input name="total_amount" type="number" step="0.01" value="{{ old('total_amount', $quotation->total_amount) }}" class="mt-1 block w-full border rounded px-3 py-2" required>
            @error('total_amount')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>
        <div>
            <label class="block text-sm font-medium">Status</label>
            <select name="status" class="mt-1 block w-full border rounded px-3 py-2">
                <option value="draft" @selected(old('status', $quotation->status) == 'draft')>Draft</option>
                <option value="sent" @selected(old('status', $quotation->status) == 'sent')>Sent</option>
                <option value="accepted" @selected(old('status', $quotation->status) == 'accepted')>Accepted</option>
                <option value="rejected" @selected(old('status', $quotation->status) == 'rejected')>Rejected</option>
            </select>
            @error('status')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div>
            <label class="block text-sm font-medium">Notes</label>
            <textarea name="notes" class="mt-1 block w-full border rounded px-3 py-2">{{ old('notes', $quotation->notes) }}</textarea>
            @error('notes')<div class="text-red-600 text-sm">{{ $message }}</div>@enderror
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
            <a href="{{ route('quotations.index') }}" class="px-4 py-2 border rounded">Cancel</a>
        </div>
    </form>

@endsection
