@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold">{{ $vendor->name }}</h2>

    <div class="mt-4 grid gap-2 max-w-lg">
        <div><strong>Contact:</strong> {{ $vendor->contact_person }}</div>
        <div><strong>Email:</strong> {{ $vendor->email }}</div>
        <div><strong>Phone:</strong> {{ $vendor->phone }}</div>
        <div><strong>Address:</strong> <pre class="whitespace-pre-wrap">{{ $vendor->address }}</pre></div>
        <div><strong>GSTIN:</strong> {{ $vendor->gstin }}</div>
        <div><strong>Status:</strong> {{ ucfirst($vendor->status) }}</div>
    </div>

    <div class="mt-4">
        <a href="{{ route('vendors.index') }}" class="btn">Back</a>
    </div>
</div>
@endsection
