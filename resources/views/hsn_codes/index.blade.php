@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">HSN Codes</h2>
        @can('create', App\Models\HsnCode::class)
            <a href="{{ route('hsn-codes.create') }}" class="btn btn-primary">New HSN</a>
        @endcan
    </div>

    <form method="GET" class="mb-4">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search code or description" class="input" />
        <button class="btn">Filter</button>
    </form>

    <div class="grid gap-3">
        @foreach($hsns as $hsn)
            <div class="card flex justify-between items-center">
                <div>
                    <div class="font-semibold">{{ $hsn->code }}</div>
                    <div class="text-sm text-gray-600">{{ $hsn->description }}</div>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('hsn-codes.show', $hsn) }}" class="btn btn-sm">View</a>
                    @can('update', $hsn)
                        <a href="{{ route('hsn-codes.edit', $hsn) }}" class="btn btn-sm">Edit</a>
                    @endcan
                    @can('delete', $hsn)
                        <form action="{{ route('hsn-codes.destroy', $hsn) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete HSN?')">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $hsns->links() }}</div>
</div>
@endsection
