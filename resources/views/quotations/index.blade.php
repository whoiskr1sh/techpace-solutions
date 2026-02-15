@extends('layouts.dashboard')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Quotations</h2>
    <div class="flex items-center gap-2">
        @can('create', App\Models\Quotation::class)
            <a href="{{ route('quotations.create') }}" class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New Quotation</a>
        @endcan
    </div>
</div>

<form method="GET" action="{{ route('quotations.index') }}" class="mb-4 flex gap-2 items-end">
    <div>
        <label class="text-xs">Search</label>
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search" class="border rounded px-2 py-1 text-sm">
    </div>
    <div>
        <label class="text-xs">Status</label>
        <select name="status" class="border rounded px-2 py-1 text-sm">
            <option value="">All</option>
            <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
            <option value="sent" {{ request('status')=='sent' ? 'selected' : '' }}>Sent</option>
            <option value="accepted" {{ request('status')=='accepted' ? 'selected' : '' }}>Accepted</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="converted" {{ request('status')=='converted' ? 'selected' : '' }}>Converted</option>
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
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="border rounded px-2 py-1 text-sm" />
    </div>
    <div>
        <label class="text-xs">To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="border rounded px-2 py-1 text-sm" />
    </div>
    <div class="flex gap-2">
        <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        <a href="{{ route('quotations.index', array_merge(request()->all(), ['export'=>'csv'])) }}" class="px-3 py-1 bg-green-600 text-white rounded">Export CSV</a>
        <a href="{{ route('quotations.index', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="px-3 py-1 bg-indigo-600 text-white rounded">Export PDF</a>
    </div>
</form>

<div class="bg-white rounded shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-xs text-left text-gray-600">
            <tr>
                <th class="p-3">#</th>
                <th class="p-3">Customer</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
                <th class="p-3">Created By</th>
                <th class="p-3">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotations as $quotation)
            <tr class="border-t">
                <td class="p-3">{{ $quotation->quotation_number }}</td>
                <td class="p-3">{{ $quotation->customer_name }}<div class="text-xs text-gray-500">{{ $quotation->customer_email }}</div></td>
                <td class="p-3">{{ number_format($quotation->total_amount,2) }}</td>
                <td class="p-3"><x-status-badge status="{{ $quotation->status }}" /></td>
                <td class="p-3">{{ $quotation->creator?->name }}</td>
                <td class="p-3">
                    <div class="flex items-center gap-2">
                        @can('view', $quotation)
                        <a href="{{ route('quotations.show', $quotation) }}" class="text-blue-600">View</a>
                        @endcan
                        @can('update', $quotation)
                        <a href="{{ route('quotations.edit', $quotation) }}" class="text-yellow-600">Edit</a>
                        @endcan
                        @can('delete', $quotation)
                        <form method="POST" action="{{ route('quotations.destroy', $quotation) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="text-red-600">Delete</button></form>
                        @endcan
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">{{ $quotations->links() }}</div>

@endsection
