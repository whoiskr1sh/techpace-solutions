@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Duplicate Quotations</h2>

    <div class="grid gap-3">
        @foreach($dqs as $dq)
            <div class="card flex justify-between items-center">
                <div>
                    <div class="font-semibold">Original: {{ $dq->original->quotation_number ?? '—' }}</div>
                    <div class="text-sm text-gray-600">Duplicate: {{ $dq->duplicate->quotation_number ?? '—' }}</div>
                </div>
                <div class="space-x-2">
                    <a href="{{ route('duplicate-quotations.show', $dq) }}" class="btn btn-sm">View</a>
                    <form action="{{ route('duplicate-quotations.destroy', $dq) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete record?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">{{ $dqs->links() }}</div>
</div>
@endsection
