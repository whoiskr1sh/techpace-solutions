@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Vendors</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('vendors.create') }}"
                class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded text-sm hover:bg-blue-700">New
                Vendor</a>
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search..."
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <label class="text-xs">Status</label>
            <select name="status" class="border rounded px-2 py-1 text-sm">
                <option value="">All</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">Name</th>
                    <th class="p-3">Contact Person</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vendors as $vendor)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $vendor->name }}</td>
                        <td class="p-3">{{ $vendor->contact_person }}</td>
                        <td class="p-3">
                            @if($vendor->status === 'active')
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Active</span>
                            @else
                                <span
                                    class="px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs">{{ ucfirst($vendor->status) }}</span>
                            @endif
                        </td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('vendors.show', $vendor) }}" class="text-blue-600">View</a>
                                @can('update', $vendor)
                                    <a href="{{ route('vendors.edit', $vendor) }}" class="text-yellow-600">Edit</a>
                                @endcan
                                @can('delete', $vendor)
                                    <form action="{{ route('vendors.destroy', $vendor) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete vendor?')">
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

    <div class="mt-4">{{ $vendors->links() }}</div>
@endsection