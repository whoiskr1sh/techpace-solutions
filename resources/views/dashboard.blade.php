@extends('layouts.dashboard')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <x-card title="Total Quotations" meta="Last 30 days">
            124
        </x-card>
        <x-card title="Open Sales Orders" meta="Unshipped">
            23
        </x-card>
        <x-card title="Outstanding Invoices" meta="Due within 30 days">
            $12,540
        </x-card>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-4">
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Recent Quotations</h3>
                        <p class="text-xs text-gray-500">Latest 5</p>
                    </div>
                    <a href="#" class="text-sm text-blue-600">View all</a>
                </div>
                <div class="mt-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500">
                                <th class="pb-2">#</th>
                                <th class="pb-2">Customer</th>
                                <th class="pb-2">Total</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="py-2">Q-00123</td>
                                <td class="py-2">ABC Pvt Ltd</td>
                                <td class="py-2">$4,200</td>
                                <td class="py-2"><x-status-badge status="sent" /></td>
                            </tr>
                            <tr>
                                <td class="py-2">Q-00124</td>
                                <td class="py-2">XYZ Traders</td>
                                <td class="py-2">$1,200</td>
                                <td class="py-2"><x-status-badge status="draft" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>

        <div class="space-y-4">
            <x-card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Shipments</h3>
                        <p class="text-xs text-gray-500">Recent courier updates</p>
                    </div>
                    <a href="#" class="text-sm text-blue-600">Manage</a>
                </div>
                <div class="mt-4">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-500">
                                <th class="pb-2">Tracking</th>
                                <th class="pb-2">Order</th>
                                <th class="pb-2">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <tr>
                                <td class="py-2">TRK123456</td>
                                <td class="py-2">SO-1001</td>
                                <td class="py-2"><x-status-badge status="in_transit" /></td>
                            </tr>
                            <tr>
                                <td class="py-2">TRK123457</td>
                                <td class="py-2">SO-1002</td>
                                <td class="py-2"><x-status-badge status="delivered" /></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-card>
        </div>
    </div>

@endsection
