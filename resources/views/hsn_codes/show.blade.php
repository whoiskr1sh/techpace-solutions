@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold">{{ $hsn->code }}</h2>

    <div class="mt-4 grid gap-2 max-w-lg">
        <div><strong>Description:</strong> {{ $hsn->description }}</div>
        <div><strong>GST Rate:</strong> {{ $hsn->gst_rate }}%</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('hsn-codes.index') }}" class="btn">Back</a>
    </div>
</div>
@endsection
