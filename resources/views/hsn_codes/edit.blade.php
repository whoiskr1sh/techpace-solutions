@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Edit HSN Code</h2>

    <form method="POST" action="{{ route('hsn-codes.update', $hsn_code) }}">
        @csrf
        @method('PUT')
        <div class="grid gap-3 max-w-lg">
            <input name="code" value="{{ old('code', $hsn_code->code) }}" placeholder="HSN code" class="input" required />
            <input name="gst_rate" value="{{ old('gst_rate', $hsn_code->gst_rate) }}" placeholder="GST rate" class="input" required />
            <textarea name="description" placeholder="Description" class="input">{{ old('description', $hsn_code->description) }}</textarea>

            <div>
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('hsn-codes.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
