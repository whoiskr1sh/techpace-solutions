@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Proforma Invoices</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('proforma-invoices.create') }}"
                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New PI</a>
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search PI#"
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <label class="text-xs">Status</label>
            <select name="status" class="border rounded px-2 py-1 text-sm">
                <option value="">All</option>
                <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="issued" {{ request('status') == 'issued' ? 'selected' : '' }}>Issued</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">PI #</th>
                    <th class="p-3">Customer</th>
                    <th class="p-3">Date</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pis as $pi)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $pi->pi_number }}</td>
                        <td class="p-3">{{ $pi->customer_name }}</td>
                        <td class="p-3">{{ optional($pi->issue_date)->format('Y-m-d') }}</td>
                        <td class="p-3"><x-status-badge status="{{ $pi->status }}" /></td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('proforma-invoices.show', $pi) }}" class="text-blue-600">View</a>
                                @can('update', $pi)
                                    <a href="{{ route('proforma-invoices.edit', $pi) }}" class="text-yellow-600">Edit</a>
                                @endcan
                                @can('delete', $pi)
                                    <form action="{{ route('proforma-invoices.destroy', $pi) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete PI?')">
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

    <div class="mt-4">{{ $pis->links() }}</div>
@endsection