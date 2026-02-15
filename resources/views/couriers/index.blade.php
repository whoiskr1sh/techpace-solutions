@extends('layouts.dashboard')

@section('content')
<div class="bg-white shadow rounded p-6">
    <h2 class="text-lg font-semibold mb-4">Couriers</h2>
    <p class="text-gray-600">This is a placeholder list for courier shipments. You can replace this with a full Courier resource later.</p>

    <table class="w-full mt-4 text-sm">
        <thead>
            <tr class="text-left text-gray-600">
                <th class="pb-2">Tracking</th>
                <th class="pb-2">Order</th>
                <th class="pb-2">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="py-2">TRK123456</td>
                <td class="py-2">SO-1001</td>
                <td class="py-2">In Transit</td>
            </tr>
            <tr>
                <td class="py-2">TRK123457</td>
                <td class="py-2">SO-1002</td>
                <td class="py-2">Delivered</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
