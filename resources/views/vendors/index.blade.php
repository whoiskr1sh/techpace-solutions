@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Vendors</h2>
        <a href="{{ route('vendors.create') }}" class="btn btn-primary">New Vendor</a>
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..." class="input" />
        <select name="status" class="input">
            <option value="">All</option>
            <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button class="btn">Filter</button>
    </form>

    <div class="grid gap-4">
        @foreach($vendors as $vendor)
            <div class="card">
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold">{{ $vendor->name }}</h3>
                        <div class="text-sm text-gray-600">{{ $vendor->contact_person }}</div>
                    </div>
                    <div class="space-x-2">
                        <a href="{{ route('vendors.show', $vendor) }}" class="btn btn-sm">View</a>
                        @can('update', $vendor)
                            <a href="{{ route('vendors.edit', $vendor) }}" class="btn btn-sm">Edit</a>
                        @endcan
                        @can('delete', $vendor)
                            <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete vendor?')">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $vendors->links() }}</div>
</div>
@endsection
