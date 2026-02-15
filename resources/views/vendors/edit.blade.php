@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Edit Vendor</h2>

    <form method="POST" action="{{ route('vendors.update', $vendor) }}">
        @csrf
        @method('PUT')
        <div class="grid gap-3 max-w-lg">
            <input name="name" value="{{ old('name', $vendor->name) }}" placeholder="Name" class="input" required />
            <input name="contact_person" value="{{ old('contact_person', $vendor->contact_person) }}" placeholder="Contact person" class="input" />
            <input name="email" value="{{ old('email', $vendor->email) }}" placeholder="Email" class="input" />
            <input name="phone" value="{{ old('phone', $vendor->phone) }}" placeholder="Phone" class="input" />
            <textarea name="address" placeholder="Address" class="input">{{ old('address', $vendor->address) }}</textarea>
            <input name="gstin" value="{{ old('gstin', $vendor->gstin) }}" placeholder="GSTIN" class="input" />
            <select name="status" class="input">
                <option value="active" {{ $vendor->status=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $vendor->status=='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <div>
                <button class="btn btn-primary">Update</button>
                <a href="{{ route('vendors.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
