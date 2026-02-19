@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Invoices</h2>
        <div class="flex items-center gap-2">
            @can('create', App\Models\Invoice::class)
                <a href="{{ route('invoices.create') }}"
                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New Invoice</a>
            @endcan
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search Invoice#"
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <label class="text-xs">Status</label>
            <select name="status" class="border rounded px-2 py-1 text-sm">
                <option value="">All Statuses</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="text-xs">User</label>
            <select name="user_id" class="border rounded px-2 py-1 text-sm">
                <option value="">Any</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs">From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}"
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <label class="text-xs">To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded px-2 py-1 text-sm" />
        </div>
        <div class="flex gap-2">
            <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">Invoice #</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $invoice->invoice_number }}</td>
                        <td class="p-3">{{ $invoice->customer_name }}</td>
                        <td class="p-3">
                            {{ $invoice->issue_date ? \Carbon\Carbon::parse($invoice->issue_date)->format('Y-m-d') : '' }}
                        </td>
                        <td class="p-3"><x-status-badge status="{{ $invoice->status }}" /></td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-blue-600">View</a>
                                @can('update', $invoice)
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="text-yellow-600">Edit</a>
                                @endcan
                                @can('delete', $invoice)
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete invoice?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Delete</button>
                                    </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $invoices->links() }}</div>
@endsection