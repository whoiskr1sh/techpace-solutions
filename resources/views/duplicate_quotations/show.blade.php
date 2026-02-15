@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-semibold mb-4">Duplicate Quotation</h2>

    <div class="grid gap-2 max-w-lg">
        <div><strong>Original:</strong> {{ $dq->original->quotation_number ?? '—' }}</div>
        <div><strong>Duplicate:</strong> {{ $dq->duplicate->quotation_number ?? '—' }}</div>
        <div><strong>Reason:</strong> <pre class="whitespace-pre-wrap">{{ $dq->reason }}</pre></div>
    </div>

    <div class="mt-4">
        <a href="{{ route('duplicate-quotations.index') }}" class="btn">Back</a>
    </div>
</div>
@endsection
