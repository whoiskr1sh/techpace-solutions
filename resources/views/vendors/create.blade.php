@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Create Vendor</h2>

    <form method="POST" action="{{ route('vendors.store') }}">
        @csrf
        <div class="grid gap-3 max-w-lg">
            <input name="name" value="{{ old('name') }}" placeholder="Name" class="input" required />
            <input name="contact_person" value="{{ old('contact_person') }}" placeholder="Contact person" class="input" />
            <input name="email" value="{{ old('email') }}" placeholder="Email" class="input" />
            <input name="phone" value="{{ old('phone') }}" placeholder="Phone" class="input" />
            <textarea name="address" placeholder="Address" class="input">{{ old('address') }}</textarea>
            <input name="gstin" value="{{ old('gstin') }}" placeholder="GSTIN" class="input" />
            <select name="status" class="input">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>

            <div>
                <button class="btn btn-primary">Save</button>
                <a href="{{ route('vendors.index') }}" class="btn">Cancel</a>
            </div>
        </div>
    </form>
</div>
@endsection
