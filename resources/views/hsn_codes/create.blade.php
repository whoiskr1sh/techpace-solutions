@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Create HSN Code</h2>

    <form method="POST" action="{{ route('hsn-codes.store') }}">
        @csrf
        <div class="grid gap-3 max-w-lg">
            <input name="code" value="{{ old('code') }}" placeholder="HSN code" class="input" required />
            <input name="gst_rate" value="{{ old('gst_rate',0) }}" placeholder="GST rate" class="input" required />
            <textarea name="description" placeholder="Description" class="input">{{ old('description') }}</textarea>

            <div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('hsn-codes.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
