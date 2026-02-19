@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">HSN Codes</h2>
        <div class="flex items-center gap-2">
            @can('create', App\Models\HsnCode::class)
                <a href="{{ route('hsn-codes.create') }}"
                    class="inline-flex items-center px-3 py-2 bg-blue-600 text-white rounded">New HSN</a>
            @endcan
        </div>
    </div>

    <form method="GET" class="mb-4 flex gap-2 items-end">
        <div>
            <label class="text-xs">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search code..."
                class="border rounded px-2 py-1 text-sm" />
        </div>
        <div>
            <button class="px-3 py-1 bg-gray-200 rounded">Filter</button>
        </div>
    </form>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">Code</th>
                    <th class="p-3">Description</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hsns as $hsn)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $hsn->code }}</td>
                        <td class="p-3">{{ $hsn->description }}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('hsn-codes.show', $hsn) }}" class="text-blue-600">View</a>
                                @can('update', $hsn)
                                    <a href="{{ route('hsn-codes.edit', $hsn) }}" class="text-yellow-600">Edit</a>
                                @endcan
                                @can('delete', $hsn)
                                    <form action="{{ route('hsn-codes.destroy', $hsn) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Delete HSN?')">
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

    <div class="mt-4">{{ $hsns->links() }}</div>
@endsection