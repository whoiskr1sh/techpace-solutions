@extends('layouts.dashboard')

@section('content')
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-semibold">Couriers</h2>
        <!-- Placeholder actions if needed, or empty -->
    </div>

    <div class="mb-4">
        <p class="text-gray-600 text-sm">This is a placeholder list for courier shipments.</p>
    </div>

    <div class="bg-white rounded shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-xs text-left text-gray-600">
                <tr>
                    <th class="p-3">Tracking</th>
                    <th class="p-3">Order</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-t">
                    <td class="p-3">TRK123456</td>
                    <td class="p-3">SO-1001</td>
                    <td class="p-3">In Transit</td>
                </tr>
                <tr class="border-t">
                    <td class="p-3">TRK123457</td>
                    <td class="p-3">SO-1002</td>
                    <td class="p-3">Delivered</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection