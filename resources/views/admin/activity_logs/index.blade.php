@extends('layouts.dashboard')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="bg-white shadow-sm rounded-lg p-4">
        <h2 class="text-lg font-medium">Activity Logs</h2>

        <form method="GET" class="mt-4 grid grid-cols-1 md:grid-cols-4 gap-3">
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="p-2 border rounded" />
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="p-2 border rounded" />
            <input type="text" name="action" placeholder="action" value="{{ request('action') }}" class="p-2 border rounded" />
            <input type="text" name="model_type" placeholder="model type" value="{{ request('model_type') }}" class="p-2 border rounded" />
            <input type="number" name="user_id" placeholder="user id" value="{{ request('user_id') }}" class="p-2 border rounded" />
            <div class="col-span-1 md:col-span-4">
                <button class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
                <a href="{{ route('admin.activity-logs.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Reset</a>
            </div>
        </form>

        <div class="mt-4 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($logs as $log)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->created_at }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ optional($log->user)->name ?? 'System' }} ({{ $log->user_id }})</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->action }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->model_type }}#{{ $log->model_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $log->ip }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.activity-logs.show', $log) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
