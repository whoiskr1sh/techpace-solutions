@extends('layouts.dashboard')

@section('content')
<div class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-4">
        <h2 class="text-lg font-medium">Activity Log Detail</h2>

        <div class="mt-4 grid grid-cols-1 gap-3">
            <div><strong>Time:</strong> {{ $log->created_at }}</div>
            <div><strong>User:</strong> {{ optional($log->user)->name ?? 'System' }} ({{ $log->user_id }})</div>
            <div><strong>Action:</strong> {{ $log->action }}</div>
            <div><strong>Model:</strong> {{ $log->model_type }} #{{ $log->model_id }}</div>
            <div><strong>IP:</strong> {{ $log->ip }}</div>
            <div><strong>User Agent:</strong> {{ $log->user_agent }}</div>
            <div><strong>Route:</strong> {{ $log->route }}</div>
            <div><strong>Method:</strong> {{ $log->method }}</div>
            <div><strong>Meta:</strong>
                <pre class="p-2 bg-gray-100 rounded">{{ json_encode($log->meta, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 bg-gray-200 rounded">Back</a>
        </div>
    </div>
</div>
@endsection
