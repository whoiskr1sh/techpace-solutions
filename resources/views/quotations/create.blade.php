@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Create Quotation</h2>
        </div>

        <form method="POST" action="{{ route('quotations.store') }}" class="bg-white rounded-lg shadow-sm p-6"
            id="quotationForm">
            @csrf
            <input type="hidden" name="status" value="draft">

            <!-- Header Info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Quotation Number</label>
                    <input name="quotation_number" value="{{ old('quotation_number') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Name</label>
                    <input name="customer_name" value="{{ old('customer_name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border"
                        required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Email</label>
                    <input name="customer_email" value="{{ old('customer_email') }}" required
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm px-3 py-2 border">
                </div>
            </div>

            <!-- Items + Summary (items expanded full width; summary moved below to the right) -->
            <div class="grid grid-cols-1 gap-6 mb-6 items-start">
                <!-- Items: span full width -->
                <div class="w-full overflow-x-auto bg-white border rounded p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Items</h3>
                    <table class="min-w-full divide-y divide-gray-200" id="itemsTable">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-600">
                                <th class="px-2 py-2 text-left w-10">Sr.</th>
                                <th class="px-2 py-2 text-left">Item</th>
                                <th class="px-2 py-2 text-left w-20">Unit</th>
                                <th class="px-2 py-2 text-right w-20">Qty</th>
                                <th class="px-2 py-2 text-right w-24">Rate</th>
                                <th class="px-2 py-2 text-right w-28">Amount</th>
                                <th class="px-2 py-2 text-left w-24">Discount</th>
                                <th class="px-2 py-2 text-right w-24">Disc Val</th>
                                <th class="px-2 py-2 text-right w-28">Total</th>
                                <th class="px-2 py-2 text-right w-20">GST%</th>
                                <th class="px-2 py-2 text-right w-28">GST Amt</th>
                                <th class="px-2 py-2 w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                        </tbody>

                    </table>
                    <div class="mt-2 flex gap-4">
                        <button type="button" onclick="addItemRow()"
                            class="text-sm text-blue-600 hover:text-blue-900 font-medium">+ Add Row</button>
                        <button type="button" onclick="openAddItemModal()"
                            class="text-sm text-green-600 hover:text-green-900 font-medium">+ Create New Item</button>
                    </div>
                </div>

                <!-- Remarks (moved above summary) -->
                <div class="mb-6 w-full">
                    <label class="block text-sm font-medium text-gray-700">Remark</label>
                    <textarea name="notes" rows="3"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">{{ old('notes') }}</textarea>
                </div>

                <!-- Summary: horizontal cards under Remarks -->
                <div class="w-full mt-4">
                    <div class="bg-gray-50 p-2 rounded w-full text-sm">
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Apply GST?</label>
                            <select id="applyGst" class="mt-1 block w-full border-gray-300 rounded px-3 py-2 border">
                                <option value="1">Apply GST</option>
                                <option value="0">Do not apply</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                            <input name="subject" class="mt-1 block w-full border-gray-300 rounded px-3 py-2 border"
                                value="{{ old('subject') }}">
                        </div>

                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700">Terms & Condition</label>
                            <select name="terms" class="mt-1 block w-full border-gray-300 rounded px-3 py-2 border">
                                <option value="">Select</option>
                                <option value="100% Against PI">100% Against PI</option>
                            </select>
                        </div>

                        <div class="flex flex-wrap gap-2 mt-2">
                            <div class="bg-white rounded p-2 shadow-sm w-full sm:w-1/2 lg:w-1/4">
                                <div class="text-xs text-gray-500">Amount</div>
                                <div class="text-base font-medium text-right" id="summaryAmount">₹ 0.00</div>
                            </div>
                            <div class="bg-white rounded p-2 shadow-sm w-full sm:w-1/2 lg:w-1/4">
                                <div class="text-xs text-gray-500">Total Discount</div>
                                <div class="text-base font-medium text-right" id="summaryDiscount">₹ 0.00</div>
                            </div>
                            <div class="bg-white rounded p-2 shadow-sm w-full sm:w-1/2 lg:w-1/4">
                                <div class="text-xs text-gray-500">Total Amount</div>
                                <div class="text-base font-medium text-right" id="summaryTotal">₹ 0.00</div>
                            </div>

                            <div class="bg-white rounded p-2 shadow-sm w-full sm:w-1/2 lg:w-1/6">
                                <div class="text-xs text-gray-500">CGST</div>
                                <div class="text-base font-medium text-right" id="summaryCGST">₹ 0.00</div>
                            </div>
                            <div class="bg-white rounded p-2 shadow-sm w-full sm:w-1/2 lg:w-1/6">
                                <div class="text-xs text-gray-500">SGST</div>
                                <div class="text-base font-medium text-right" id="summarySGST">₹ 0.00</div>
                            </div>

                            <div class="bg-white rounded p-2 shadow-sm w-full lg:w-1/3">
                                <div class="text-xs text-gray-500">IGST</div>
                                <div class="text-base font-medium text-right" id="summaryIGST">₹ 0.00</div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between gap-3 mt-2">
                            <div class="flex items-center gap-2">
                                <div class="text-xs text-gray-500">Round Off</div>
                                <input type="number" id="roundOff" class="w-20 text-right border rounded px-2 py-1 text-sm"
                                    value="0" oninput="calculateNet()">
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 text-right">Net Amount</div>
                                <div class="text-base font-semibold text-right" id="netAmount">0.00</div>
                            </div>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('quotations.index') }}"
                                class="flex-1 px-2 py-1 bg-white text-gray-700 border border-gray-300 rounded text-sm">Cancel</a>
                            <button type="submit" class="flex-1 px-2 py-1 bg-blue-600 text-white rounded text-sm">Create
                                Quotation</button>
                        </div>
                    </div>
                </div>
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
            <td class="px-2 py-1 text-sm text-gray-700">SR</td>
            <td class="px-2 py-1">
                <select name="items[INDEX][name]" class="w-full border-gray-200 rounded px-2 py-1 text-xs border item-name"
                    onchange="applyItemDetails(this)">
                    <option value="">Select Item</option>
                    <!-- Options injected dynamically -->
                </select>
            </td>
            <td class="px-2 py-1">
                <select name="items[INDEX][unit]" class="w-full border-gray-200 rounded px-2 py-1 text-xs border unit">
                    <option value="Nos">Nos</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Mtr">Mtr</option>
                    <option value="Kg">Kg</option>
                    <option value="Days">Days</option>
                    <option value="ML (FOR OIL)">ML ( FOR OIL)</option>
                </select>
            </td>
            <td class="px-2 py-1"><input type="number" step="1" name="items[INDEX][qty]"
                    class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right qty" value="1"
                    oninput="calculateRow(this)"></td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="number" step="0.01" name="items[INDEX][rate]"
                        class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right rate" value="0"
                        oninput="calculateRow(this)">
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][amount]"
                        class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right amount" readonly>
                </div>
            </td>
            <td class="px-2 py-1">
                <select name="items[INDEX][discount_type]"
                    class="w-full border-gray-200 rounded px-2 py-1 text-xs border discount-type"
                    onchange="calculateRow(this)">
                    <option value="percent">% — Percent</option>
                    <option value="fixed">₹ — Fixed</option>
                </select>
            </td>
            <td class="px-2 py-1"><input type="number" step="0.01" name="items[INDEX][discount_value]"
                    class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right discount-value" value="0"
                    oninput="calculateRow(this)"></td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][total_after_discount]"
                        class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right total-after" readonly>
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <input type="number" step="0.01" name="items[INDEX][gst_percent]"
                        class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right gst-percent" value="18"
                        oninput="calculateRow(this)">
                    <span class="ml-1 text-xs">%</span>
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][gst_amount]"
                        class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right gst-amount" readonly>
                </div>
            </td>
            <td class="px-2 py-1 text-center"><button type="button" onclick="removeRow(this)"
                    class="text-red-600">&times;</button></td>
        </tr>
    </template>

    <script>
        let rowIndex = 0;
        let masterItems = @json(\App\Models\Item::orderBy('item_name')->get());

        function populateItemDropdowns() {
            // Update all existing dropdowns and template
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

            // Update existing rows but keep selected values
            document.querySelectorAll('#itemsBody .item-name').forEach(select => {
                const currentVal = select.value;
                select.innerHTML = optionsHtml;
                if (currentVal) select.value = currentVal;
            });
        }

        function applyItemDetails(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            if (!selectedOption || !selectedOption.value) return;

            const row = selectElement.closest('tr');
            const unit = selectedOption.getAttribute('data-unit');
            const gst = selectedOption.getAttribute('data-gst');

            if (unit) {
                const unitSelect = row.querySelector('.unit');
                if (unitSelect) unitSelect.value = unit;
            }
            if (gst !== null) {
                const gstInput = row.querySelector('.gst-percent');
                if (gstInput) {
                    gstInput.value = gst;
                    calculateRow(gstInput);
                }
            }
        }

        function addItemRow() {
            // make sure dropdowns have latest items before cloning
            populateItemDropdowns();

            const template = document.getElementById('itemRowTemplate');
            const clone = template.content.cloneNode(true);
            const tbody = document.getElementById('itemsBody');

            // Replace INDEX placeholder and SR number
            const html = clone.firstElementChild.outerHTML.replace(/INDEX/g, rowIndex).replace('SR', (rowIndex + 1));
            const temp = document.createElement('tbody');
            temp.innerHTML = html;
            tbody.appendChild(temp.firstElementChild);
            rowIndex++;
            calculateAll();
        }

        function removeRow(btn) {
            const row = btn.closest('tr');
            row.remove();
            calculateAll();
        }

        function calculateRow(el) {
            const row = el.closest('tr');
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const rate = parseFloat(row.querySelector('.rate').value) || 0;
            const amount = qty * rate;
            row.querySelector('.amount').value = amount.toFixed(2);

            const dtype = row.querySelector('.discount-type').value;
            const dval = parseFloat(row.querySelector('.discount-value').value) || 0;
            let totalAfter = amount;
            if (dtype === 'percent') {
                totalAfter = amount - (amount * dval / 100);
            } else {
                totalAfter = amount - dval;
            }
            row.querySelector('.total-after').value = totalAfter.toFixed(2);

            const gstp = parseFloat(row.querySelector('.gst-percent').value) || 0;
            const gstAmount = (totalAfter * gstp / 100);
            row.querySelector('.gst-amount').value = gstAmount.toFixed(2);

            calculateAll();
        }

        function calculateAll() {
            let sub = 0;
            let totalDiscount = 0;
            let totalGst = 0;
            document.querySelectorAll('#itemsBody tr').forEach(row => {
                const amount = parseFloat(row.querySelector('.amount').value) || 0;
                const totalAfter = parseFloat(row.querySelector('.total-after').value) || 0;
                const gst = parseFloat(row.querySelector('.gst-amount').value) || 0;
                sub += amount;
                totalDiscount += (amount - totalAfter);
                totalGst += gst;
            });

            document.getElementById('subTotal').value = sub.toFixed(2);
            document.getElementById('summaryAmount').innerText = '₹ ' + sub.toFixed(2);
            document.getElementById('summaryDiscount').innerText = '₹ ' + totalDiscount.toFixed(2);
            const totalAmount = sub - totalDiscount;
            document.getElementById('summaryTotal').innerText = '₹ ' + totalAmount.toFixed(2);

            // split CGST/SGST equally
            const cgst = (totalGst / 2);
            const sgst = (totalGst / 2);
            document.getElementById('summaryCGST').innerText = '₹ ' + cgst.toFixed(2);
            document.getElementById('summarySGST').innerText = '₹ ' + sgst.toFixed(2);
            document.getElementById('summaryIGST').innerText = '₹ ' + (0).toFixed(2);

            document.getElementById('netAmount').innerText = '₹ ' + (totalAmount + totalGst + parseFloat(document.getElementById('roundOff').value || 0)).toFixed(2);
        }

        function calculateNet() {
            calculateAll();
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
            if (photoInput.files.length > 0) {
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

        document.addEventListener('DOMContentLoaded', () => {
            populateItemDropdowns();
            addItemRow();
        });
    </script>
@endsection