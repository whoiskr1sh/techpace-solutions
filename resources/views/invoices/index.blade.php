@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Invoices</h2>
        @can('create', App\\Models\\Invoice::class)
            <a href="{{ route('invoices.create') }}" class="btn btn-primary">New Invoice</a>
        @endcan
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search Invoice#" class="input" />
        </div>
        <div>
            <label class="text-xs">Status</label>
            <select name="status" class="input">
                <option value="">All Statuses</option>
                <option value="draft" {{ request('status')=='draft' ? 'selected' : '' }}>Draft</option>
                <option value="issued" {{ request('status')=='issued' ? 'selected' : '' }}>Issued</option>
                <option value="paid" {{ request('status')=='paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>
        <div>
            <label class="text-xs">User</label>
            <select name="user_id" class="input">
                <option value="">Any</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ request('user_id') == $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-xs">From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="input" />
        </div>
        <div>
            <label class="text-xs">To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="input" />
        </div>
        <div class="flex gap-2">
            <button class="btn">Filter</button>
            <a href="{{ route('invoices.index', array_merge(request()->all(), ['export'=>'csv'])) }}" class="btn btn-success">Export CSV</a>
            <a href="{{ route('invoices.index', array_merge(request()->all(), ['export'=>'pdf'])) }}" class="btn btn-indigo">Export PDF</a>
        </div>
    </form>

    <div class="grid gap-4">
        @foreach($invoices as $invoice)
            <div class="card">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $invoice->invoice_number }}</h3>
                        <div class="text-sm text-gray-600">{{ $invoice->customer_name }} • {{ optional($invoice->issue_date)->format('Y-m-d') }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm">View</a>
                        @can('update', $invoice)
                            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm">Edit</a>
                        @endcan
                        @can('delete', $invoice)
                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete invoice?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $invoices->links() }}</div>
</div>
@endsection
