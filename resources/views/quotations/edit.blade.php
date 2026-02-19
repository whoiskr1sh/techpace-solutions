@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Edit Quotation</h2>
        </div>

        <form method="POST" action="{{ route('quotations.update', $quotation) }}" class="bg-white rounded-lg shadow-sm p-6"
            id="quotationForm">
            @csrf
            @method('PUT')

            <!-- Header Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quotation Number</label>
                    <input name="quotation_number" value="{{ $quotation->quotation_number }}"
                        class="mt-1 block w-full border-gray-300 rounded-md bg-gray-100 shadow-sm sm:text-sm px-3 py-2 border"
                        readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input name="customer_name" value="{{ old('customer_name', $quotation->customer_name) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border"
                        required>
                    @error('customer_name')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Email</label>
                    <input name="customer_email" value="{{ old('customer_email', $quotation->customer_email) }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                    @error('customer_email')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                        <option value="draft" @selected(old('status', $quotation->status) == 'draft')>Draft</option>
                        <option value="sent" @selected(old('status', $quotation->status) == 'sent')>Sent</option>
                        <option value="accepted" @selected(old('status', $quotation->status) == 'accepted')>Accepted</option>
                        <option value="rejected" @selected(old('status', $quotation->status) == 'rejected')>Rejected</option>
                        <option value="converted" @selected(old('status', $quotation->status) == 'converted')>Converted
                        </option>
                    </select>
                </div>
                <div>
                    <label class="flex items-center space-x-2 mt-6">
                        <input type="checkbox" name="is_usd" value="1" @checked(old('is_usd', $quotation->currency === 'USD'))
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="text-sm font-medium text-gray-700">Price in USD</span>
                    </label>
                </div>
            </div>

            <!-- Line Items -->
            <div class="mb-6 overflow-x-auto">
                <h3 class="text-lg font-medium text-gray-900 mb-2">Line Items</h3>
                <table class="min-w-full divide-y divide-gray-200 border" id="itemsTable">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Make
                            </th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Model
                                No</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Unit Price</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                                Disc (%)</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Unit Disc.</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                                Qty</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Total</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Delivery</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Remarks</th>
                            <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                        @foreach(old('items', $quotation->items->count() ? $quotation->items : []) as $index => $item)
                            <tr>
                                @php
                                    $item = (object) $item; // Handle array from old() or object from Model
                                    $unitPrice = $item->unit_price ?? 0;
                                    $discount = $item->discount ?? 0;
                                    $qty = $item->quantity ?? 1;
                                    $unitDiscPrice = $unitPrice - ($unitPrice * $discount / 100);
                                    $totalPrice = $unitDiscPrice * $qty;
                                @endphp
                                <td class="px-2 py-2"><input name="items[{{$index}}][make]" value="{{ $item->make ?? '' }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
                                </td>
                                <td class="px-2 py-2"><input name="items[{{$index}}][model_no]"
                                        value="{{ $item->model_no ?? '' }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
                                </td>
                                <td class="px-2 py-2"><input type="number" step="0.01" name="items[{{$index}}][unit_price]"
                                        value="{{ $item->unit_price ?? '' }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border unit-price"
                                        oninput="calculateRow(this)"></td>
                                <td class="px-2 py-2"><input type="number" step="0.01" name="items[{{$index}}][discount]"
                                        value="{{ $item->discount ?? 0 }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border discount"
                                        oninput="calculateRow(this)"></td>
                                <td class="px-2 py-2"><input type="number" step="0.01"
                                        name="items[{{$index}}][unit_discounted_price]"
                                        value="{{ number_format($unitDiscPrice, 2, '.', '') }}"
                                        class="w-full bg-gray-50 border-gray-300 rounded px-2 py-1 text-sm text-gray-500 border unit-disc-price"
                                        readonly></td>
                                <td class="px-2 py-2"><input type="number" name="items[{{$index}}][quantity]"
                                        value="{{ $item->quantity ?? 1 }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border quantity"
                                        min="1" oninput="calculateRow(this)"></td>
                                <td class="px-2 py-2"><input type="number" step="0.01" name="items[{{$index}}][total_price]"
                                        value="{{ number_format($totalPrice, 2, '.', '') }}"
                                        class="w-full bg-gray-50 border-gray-300 rounded px-2 py-1 text-sm text-gray-500 border total-price"
                                        readonly></td>
                                <td class="px-2 py-2"><input type="date" name="items[{{$index}}][delivery_time]"
                                        value="{{ $item->delivery_time ?? '' }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
                                </td>
                                <td class="px-2 py-2"><input name="items[{{$index}}][remarks]"
                                        value="{{ $item->remarks ?? '' }}"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
                                </td>
                                <td class="px-2 py-2 text-center">
                                    <button type="button" onclick="removeRow(this)" class="text-red-600 hover:text-red-900">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="6" class="px-3 py-3 text-right font-bold text-gray-700">Grand Total:</td>
                            <td class="px-3 py-3">
                                <input type="number" name="total_amount" id="grandTotal"
                                    class="w-full border-transparent bg-transparent font-bold text-gray-900 focus:ring-0 text-right"
                                    readonly value="{{ number_format($quotation->total_amount, 2, '.', '') }}">
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
                <button type="button" onclick="addItemRow()"
                    class="mt-2 text-sm text-blue-600 hover:text-blue-900 font-medium">+ Add Item</button>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Notes</label>
                <textarea name="notes" rows="3"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">{{ old('notes', $quotation->notes) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('quotations.index') }}"
                    class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-md shadow-sm text-sm font-medium hover:bg-gray-50">Cancel</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm text-sm font-medium hover:bg-blue-700">Update
                    Quotation</button>
            </div>
        </form>
    </div>

    <template id="itemRowTemplate">
        <tr>
            <td class="px-2 py-2"><input name="items[INDEX][make]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
            </td>
            <td class="px-2 py-2"><input name="items[INDEX][model_no]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
            </td>
            <td class="px-2 py-2"><input type="number" step="0.01" name="items[INDEX][unit_price]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border unit-price"
                    oninput="calculateRow(this)"></td>
            <td class="px-2 py-2"><input type="number" step="0.01" name="items[INDEX][discount]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border discount"
                    value="0" oninput="calculateRow(this)"></td>
            <td class="px-2 py-2"><input type="number" step="0.01" name="items[INDEX][unit_discounted_price]"
                    class="w-full bg-gray-50 border-gray-300 rounded px-2 py-1 text-sm text-gray-500 border unit-disc-price"
                    readonly></td>
            <td class="px-2 py-2"><input type="number" name="items[INDEX][quantity]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border quantity"
                    value="1" min="1" oninput="calculateRow(this)"></td>
            <td class="px-2 py-2"><input type="number" step="0.01" name="items[INDEX][total_price]"
                    class="w-full bg-gray-50 border-gray-300 rounded px-2 py-1 text-sm text-gray-500 border total-price"
                    readonly></td>
            <td class="px-2 py-2"><input type="date" name="items[INDEX][delivery_time]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
            </td>
            <td class="px-2 py-2"><input name="items[INDEX][remarks]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border">
            </td>
            <td class="px-2 py-2 text-center">
                <button type="button" onclick="removeRow(this)" class="text-red-600 hover:text-red-900">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </td>
        </tr>
    </template>

    <script>
        // Start index after existing rows
        let rowIndex = {{ count(old('items', $quotation->items->count() ? $quotation->items : [])) }};

        // If 0, start at 0
        if (rowIndex == 0) rowIndex = 0;

        function addItemRow() {
            const template = document.getElementById('itemRowTemplate');
            const clone = template.content.cloneNode(true);
            const tbody = document.getElementById('itemsBody');

            // Replace INDEX placeholder
            const inputs = clone.querySelectorAll('input');
            inputs.forEach(input => {
                input.name = input.name.replace('INDEX', rowIndex);
            });

            tbody.appendChild(clone);
            rowIndex++;
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            calculateGrandTotal();
        }

        function calculateRow(input) {
            const row = input.closest('tr');
            const unitPrice = parseFloat(row.querySelector('.unit-price').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;

            const unitDiscPrice = unitPrice - (unitPrice * discount / 100);
            const totalPrice = unitDiscPrice * quantity;

            row.querySelector('.unit-disc-price').value = unitDiscPrice.toFixed(2);
            row.querySelector('.total-price').value = totalPrice.toFixed(2);

            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.total-price').forEach(input => {
                total += parseFloat(input.value) || 0;
            });
            document.getElementById('grandTotal').value = total.toFixed(2);
        }

        // Add initial row if empty
        document.addEventListener('DOMContentLoaded', () => {
            const tbody = document.getElementById('itemsBody');
            if (tbody.children.length === 0) {
                addItemRow();
            }
        });
    </script>
@endsection