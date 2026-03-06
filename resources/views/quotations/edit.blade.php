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
                                <td class="px-2 py-2">
                                    <select name="items[{{$index}}][make]"
                                        class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border item-name"
                                        data-selected="{{ $item->make ?? '' }}">
                                        <option value="">Select Item</option>
                                    </select>
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
                <div class="mt-2 flex gap-4">
                    <button type="button" onclick="addItemRow()"
                        class="text-sm text-blue-600 hover:text-blue-900 font-medium">+ Add Row</button>
                    <button type="button" onclick="openAddItemModal()"
                        class="text-sm text-green-600 hover:text-green-900 font-medium">+ Create New Item</button>
                </div>
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
            <div id="addItemModal"
                class="hidden fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 flex items-center justify-center">
                <div class="bg-white rounded-lg shadow-xl w-11/12 md:w-3/4 max-w-4xl p-6 relative">
                    <button type="button" onclick="closeAddItemModal()"
                        class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Add Item</h3>

                    <div id="addItemErrors" class="hidden mb-4 p-3 bg-red-100 text-red-700 rounded text-sm"></div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type of Item *</label>
                            <select id="modal_type_of_item"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                                <option value="SERVICE">Service</option>
                                <option value="TRADING">Trading</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Group Of Item</label>
                            <input type="text" id="modal_group_of_item"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Item Name *</label>
                            <input type="text" id="modal_item_name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Item Description</label>
                            <textarea id="modal_item_description" rows="2"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border"></textarea>
                        </div>
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Primary Unit</label>
                                    <select id="modal_primary_unit"
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                                        <option value="">Select Unit</option>
                                        <option value="Nos">Nos</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Mtr">Mtr</option>
                                        <option value="Kg">Kg</option>
                                        <option value="Days">Days</option>
                                        <option value="ML (FOR OIL)">ML ( FOR OIL)</option>
                                    </select>
                                </div>
                                <div class="flex items-center mt-6">
                                    <input type="checkbox" id="modal_is_freez"
                                        class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-700">Freez</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">GST (%)</label>
                            <input type="number" step="0.01" id="modal_gst_percent"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border"
                                value="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">IGST (%)</label>
                            <input type="number" step="0.01" id="modal_igst_percent"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border"
                                value="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">HSN CODE</label>
                            <input type="text" id="modal_hsn_code"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                        </div>
                        <div class="flex items-center mt-6">
                            <input type="checkbox" id="modal_is_machine"
                                class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-700">Is Machine?</label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Account Group</label>
                            <input type="text" id="modal_account_group"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Upload Photo</label>
                            <input type="file" id="modal_photo" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-4 pt-4 border-t">
                        <button type="button" onclick="closeAddItemModal()"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">Cancel</button>
                        <button type="button" onclick="submitAddItem()"
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium"
                            id="btnSubmitAddItem">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <template id="itemRowTemplate">
        <tr>
            <td class="px-2 py-2">
                <select name="items[INDEX][make]"
                    class="w-full border-gray-300 rounded px-2 py-1 text-sm focus:ring-blue-500 focus:border-blue-500 border item-name">
                    <option value="">Select Item</option>
                    <!-- Options injected dynamically -->
                </select>
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
        let masterItems = @json(\App\Models\Item::orderBy('item_name')->get());

        // If 0, start at 0
        if (rowIndex == 0) rowIndex = 0;

        function populateItemDropdowns() {
            let optionsHtml = '<option value="">Select Item</option>';
            masterItems.forEach(item => {
                optionsHtml += `<option value="${item.item_name}" data-unit="${item.primary_unit || ''}" data-gst="${item.gst_percent || 0}">${item.item_name}</option>`;
            });

            // Update template
            const template = document.getElementById('itemRowTemplate');
            const selectTemplate = template.content.querySelector('.item-name');
            if (selectTemplate) {
                selectTemplate.innerHTML = optionsHtml;
            }

            // Update existing rows
            document.querySelectorAll('#itemsBody .item-name').forEach(select => {
                const currentVal = select.getAttribute('data-selected') || select.value;
                select.innerHTML = optionsHtml;
                if (currentVal) {
                    select.value = currentVal;
                    // Ensure the selected attribute persists for template reloading if they re-render
                    select.setAttribute('data-selected', currentVal);
                }
            });
        }

        function addItemRow() {
            populateItemDropdowns();
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

        function openAddItemModal() {
            document.getElementById('addItemErrors').classList.add('hidden');
            // reset form
            document.getElementById('modal_type_of_item').value = 'SERVICE';
            document.getElementById('modal_group_of_item').value = '';
            document.getElementById('modal_item_name').value = '';
            document.getElementById('modal_item_description').value = '';
            document.getElementById('modal_primary_unit').value = '';
            document.getElementById('modal_is_freez').checked = false;
            document.getElementById('modal_gst_percent').value = '0';
            document.getElementById('modal_igst_percent').value = '0';
            document.getElementById('modal_hsn_code').value = '';
            document.getElementById('modal_is_machine').checked = false;
            document.getElementById('modal_account_group').value = '';
            document.getElementById('modal_photo').value = '';

            document.getElementById('addItemModal').classList.remove('hidden');
        }

        function closeAddItemModal() {
            document.getElementById('addItemModal').classList.add('hidden');
        }

        function submitAddItem() {
            const btn = document.getElementById('btnSubmitAddItem');
            btn.disabled = true;
            btn.innerText = 'Submitting...';
            document.getElementById('addItemErrors').classList.add('hidden');

            const formData = new FormData();
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('type_of_item', document.getElementById('modal_type_of_item').value);
            formData.append('group_of_item', document.getElementById('modal_group_of_item').value);
            formData.append('item_name', document.getElementById('modal_item_name').value);
            formData.append('item_description', document.getElementById('modal_item_description').value);
            formData.append('primary_unit', document.getElementById('modal_primary_unit').value);
            if (document.getElementById('modal_is_freez').checked) formData.append('is_freez', 1);
            formData.append('gst_percent', document.getElementById('modal_gst_percent').value);
            formData.append('igst_percent', document.getElementById('modal_igst_percent').value);
            formData.append('hsn_code', document.getElementById('modal_hsn_code').value);
            if (document.getElementById('modal_is_machine').checked) formData.append('is_machine', 1);
            formData.append('account_group', document.getElementById('modal_account_group').value);

            const photoInput = document.getElementById('modal_photo');
            if (photoInput && photoInput.files.length > 0) {
                formData.append('photo', photoInput.files[0]);
            }

            fetch('{{ route("items.store") }}', {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    btn.disabled = false;
                    btn.innerText = 'Submit';
                    if (data.success) {
                        masterItems.push(data.item);
                        masterItems.sort((a, b) => a.item_name.localeCompare(b.item_name));
                        populateItemDropdowns();
                        closeAddItemModal();
                    } else {
                        const errorBox = document.getElementById('addItemErrors');
                        errorBox.innerHTML = typeof data.message === 'string' ? data.message : 'Validation Error. Please check fields.';
                        errorBox.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    btn.disabled = false;
                    btn.innerText = 'Submit';
                    const errorBox = document.getElementById('addItemErrors');
                    errorBox.innerHTML = 'An unexpected error occurred.';
                    errorBox.classList.remove('hidden');
                });
        }

        // Add initial row if empty
        document.addEventListener('DOMContentLoaded', () => {
            populateItemDropdowns();
            const tbody = document.getElementById('itemsBody');
            if (tbody.children.length === 0) {
                addItemRow();
            }
        });
    </script>
@endsection