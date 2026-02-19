@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Duplicate Quotations</h2>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">Original</th>
                    <th class="p-3">Duplicate</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dqs as $dq)
                    <tr class="border-t">
                        <td class="p-3 font-medium">{{ $dq->original->quotation_number ?? '—' }}</td>
                        <td class="p-3">{{ $dq->duplicate->quotation_number ?? '—' }}</td>
                        <td class="p-3">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('duplicate-quotations.show', $dq) }}" class="text-blue-600">View</a>
                                <form action="{{ route('duplicate-quotations.destroy', $dq) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Delete record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $dqs->links() }}</div>
@endsection