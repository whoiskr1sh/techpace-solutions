@extends('layouts.dashboard')

@section('content')
<div class="p-6">
    <h2 class="text-lg font-semibold mb-4">Settings</h2>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="invoices_visible_for_sales" value="1" {{ $invoices_visible_for_sales == '1' ? 'checked' : '' }} />
                <span>Invoices visible to Sales users</span>
            </label>
        </div>

        <div>
            <button class="btn btn-primary">Save</button>
        </div>
    </form>
</div>
@endsection
