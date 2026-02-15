@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Proforma Invoices</h2>
        <a href="{{ route('proforma-invoices.create') }}" class="btn btn-primary">New PI</a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search PI#" class="input" />
        <select name="status" class="input">
            <option value="">All</option>
            <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
            <option value="issued" {{ request('status')=='issued' ? 'selected' : '' }}>Issued</option>
            <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button class="btn">Filter</button>
    </form>

    <div class="grid gap-4">
        @foreach($pis as $pi)
            <div class="card">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $pi->pi_number }}</h3>
                        <div class="text-sm text-gray-600">{{ $pi->customer_name }} • {{ optional($pi->issue_date)->format('Y-m-d') }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('proforma-invoices.show', $pi) }}" class="btn btn-sm">View</a>
                        @can('update', $pi)
                            <a href="{{ route('proforma-invoices.edit', $pi) }}" class="btn btn-sm">Edit</a>
                        @endcan
                        @can('delete', $pi)
                            <form action="{{ route('proforma-invoices.destroy', $pi) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete PI?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $pis->links() }}</div>
</div>
@endsection
