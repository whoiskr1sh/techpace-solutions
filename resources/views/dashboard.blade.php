@extends('layouts.dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Quotations -->
        <div
            class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Total Quotations</p>
                    <h3 class="text-2xl font-bold text-slate-800">124</h3>
                </div>
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-green-500 font-medium flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18">
                        </path>
                    </svg>
                    12%
                </span>
                <span class="text-slate-400 ml-2">from last month</span>
            </div>
        </div>

        <!-- Open Sales Orders -->
        <div
            class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Open Orders</p>
                    <h3 class="text-2xl font-bold text-slate-800">23</h3>
                </div>
                <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-blue-500 font-medium bg-blue-50 px-2 py-0.5 rounded-full">Unshipped</span>
            </div>
        </div>

        <!-- Outstanding Invoices -->
        <div
            class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <p class="text-sm font-medium text-slate-500 mb-1">Outstanding</p>
                    <h3 class="text-2xl font-bold text-slate-800">$12,540</h3>
                </div>
                <div class="p-2 bg-amber-50 rounded-lg text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center text-sm">
                <span class="text-amber-500 font-medium">Due within 30 days</span>
            </div>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Recent Quotations -->
        <div
            class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800">Recent Quotations</h3>
                    <p class="text-xs text-slate-500 mt-1">Latest 5 generated</p>
                </div>
                <a href="{{ route('quotations.index') }}"
                    class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">View all</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-50">
                        <tr>
                            <th class="px-6 py-4 font-semibold tracking-wider">Reference</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Customer</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Total</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700 group-hover:text-blue-600 transition-colors">
                                Q-00123</td>
                            <td class="px-6 py-4 text-slate-600">ABC Pvt Ltd</td>
                            <td class="px-6 py-4 font-medium text-slate-900">$4,200</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5"></span>
                                    Sent
                                </span>
                            </td>
                        </tr>
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4 font-medium text-slate-700 group-hover:text-blue-600 transition-colors">
                                Q-00124</td>
                            <td class="px-6 py-4 text-slate-600">XYZ Traders</td>
                            <td class="px-6 py-4 font-medium text-slate-900">$1,200</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 bg-slate-400 rounded-full mr-1.5"></span>
                                    Draft
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipments -->
        <div
            class="bg-white rounded-xl border border-slate-100 shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <div>
                    <h3 class="font-bold text-slate-800">Shipments</h3>
                    <p class="text-xs text-slate-500 mt-1">Recent courier updates</p>
                </div>
                <button class="text-sm font-medium text-blue-600 hover:text-blue-700 transition-colors">Track all</button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-slate-400 uppercase bg-slate-50/50 border-b border-slate-50">
                        <tr>
                            <th class="px-6 py-4 font-semibold tracking-wider">Tracking #</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Order Ref</th>
                            <th class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td
                                class="px-6 py-4 font-medium text-slate-700 font-mono text-xs group-hover:text-blue-600 transition-colors">
                                TRK123456</td>
                            <td class="px-6 py-4 text-slate-600">SO-1001</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <span class="w-1.5 h-1.5 bg-blue-500 rounded-full mr-1.5 animate-pulse"></span>
                                    In Transit
                                </span>
                            </td>
                        </tr>
                        <tr class="group hover:bg-slate-50/80 transition-colors">
                            <td
                                class="px-6 py-4 font-medium text-slate-700 font-mono text-xs group-hover:text-blue-600 transition-colors">
                                TRK123457</td>
                            <td class="px-6 py-4 text-slate-600">SO-1002</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-50 text-purple-700 border border-purple-100">
                                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full mr-1.5"></span>
                                    Delivered
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sales')
        <x-card>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Data Management</h3>
                    <p class="text-sm text-slate-500">Bulk actions for system data</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Import Action -->
                <div
                    class="group relative bg-slate-50 hover:bg-white border boundary-slate-200 hover:border-blue-200 rounded-xl p-5 transition-all duration-200 hover:shadow-md">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div
                                class="p-3 bg-blue-100/50 text-blue-600 rounded-lg group-hover:bg-blue-600 group-hover:text-white transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-slate-800 mb-1">Import Data</h4>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">Upload an Excel file to bulk create or update
                                Vendors, Quotations, and Orders.</p>

                            <form action="{{ route('admin.import-all') }}" method="POST" enctype="multipart/form-data"
                                class="flex gap-2 items-center">
                                @csrf
                                <label class="cursor-pointer">
                                    <span
                                        class="px-3 py-1.5 bg-white border border-slate-300 rounded-md text-xs font-medium text-slate-600 hover:bg-slate-50 transition-colors">Choose
                                        File</span>
                                    <input type="file" name="file" class="hidden" accept=".xlsx,.xls,.csv"
                                        onchange="this.form.submit()">
                                </label>
                                <span class="text-xs text-slate-400 italic">.xlsx, .csv</span>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Export Action -->
                <div
                    class="group relative bg-slate-50 hover:bg-white border boundary-slate-200 hover:border-green-200 rounded-xl p-5 transition-all duration-200 hover:shadow-md">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div
                                class="p-3 bg-green-100/50 text-green-600 rounded-lg group-hover:bg-green-600 group-hover:text-white transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-slate-800 mb-1">Export Data</h4>
                            <p class="text-xs text-slate-500 mb-4 leading-relaxed">Download a complete system backup including
                                all modules and line items.</p>

                            <a href="{{ route('admin.export-all') }}"
                                class="inline-flex items-center gap-2 px-3 py-1.5 bg-white border border-green-600 text-green-700 text-xs font-bold rounded-md hover:bg-green-50 transition-colors">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download Excel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </x-card>
    @endif

@endsection