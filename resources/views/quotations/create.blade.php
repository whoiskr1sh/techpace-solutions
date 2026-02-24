@extends('layouts.dashboard')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Create Quotation</h2>
        </div>

        <form method="POST" action="{{ route('quotations.store') }}" class="bg-white rounded-lg shadow-sm p-6" id="quotationForm">
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
                    <input name="customer_email" value="{{ old('customer_email') }}"
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
                                <th class="px-2 py-2 text-right w-28">Total+GST</th>
                                <th class="px-2 py-2 w-8"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="itemsBody">
                        </tbody>
                        
                    </table>
                    <div class="mt-2">
                        <button type="button" onclick="addItemRow()" class="text-sm text-blue-600 hover:text-blue-900 font-medium">+ Add Item</button>
                    </div>
                </div>

                <!-- Remarks (moved above summary) -->
                <div class="mb-6 w-full">
                    <label class="block text-sm font-medium text-gray-700">Remark</label>
                    <textarea name="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm sm:text-sm px-3 py-2 border">{{ old('notes') }}</textarea>
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
                            <input name="subject" class="mt-1 block w-full border-gray-300 rounded px-3 py-2 border" value="{{ old('subject') }}">
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
                                <input type="number" id="roundOff" class="w-20 text-right border rounded px-2 py-1 text-sm" value="0" oninput="calculateNet()">
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 text-right">Net Amount</div>
                                <div class="text-base font-semibold text-right" id="netAmount">0.00</div>
                            </div>
                        </div>

                        <div class="mt-3 flex gap-2">
                            <a href="{{ route('quotations.index') }}" class="flex-1 px-2 py-1 bg-white text-gray-700 border border-gray-300 rounded text-sm">Cancel</a>
                            <button type="submit" class="flex-1 px-2 py-1 bg-blue-600 text-white rounded text-sm">Create Quotation</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>

    <template id="itemRowTemplate">
        <tr>
            <td class="px-2 py-1 text-sm text-gray-700">SR</td>
            <td class="px-2 py-1"><input name="items[INDEX][name]" class="w-full border-gray-200 rounded px-2 py-1 text-xs border item-name"></td>
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
            <td class="px-2 py-1"><input type="number" step="1" name="items[INDEX][qty]" class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right qty" value="1" oninput="calculateRow(this)"></td>
                <td class="px-2 py-1">
                    <div class="flex items-center">
                        <span class="text-sm mr-1">₹</span>
                        <input type="number" step="0.01" name="items[INDEX][rate]" class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right rate" value="0" oninput="calculateRow(this)">
                    </div>
                </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][amount]" class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right amount" readonly>
                </div>
            </td>
            <td class="px-2 py-1">
                <select name="items[INDEX][discount_type]" class="w-full border-gray-200 rounded px-2 py-1 text-xs border discount-type" onchange="calculateRow(this)">
                    <option value="percent">% — Percent</option>
                    <option value="fixed">₹ — Fixed</option>
                </select>
            </td>
            <td class="px-2 py-1"><input type="number" step="0.01" name="items[INDEX][discount_value]" class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right discount-value" value="0" oninput="calculateRow(this)"></td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][total_after_discount]" class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right total-after" readonly>
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <input type="number" step="0.01" name="items[INDEX][gst_percent]" class="w-full border-gray-200 rounded px-2 py-1 text-xs text-right gst-percent" value="18" oninput="calculateRow(this)">
                    <span class="ml-1 text-xs">%</span>
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][gst_amount]" class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right gst-amount" readonly>
                </div>
            </td>
            <td class="px-2 py-1">
                <div class="flex items-center">
                    <span class="text-sm mr-1">₹</span>
                    <input type="text" name="items[INDEX][total_with_gst]" class="w-full bg-gray-50 border-gray-200 rounded px-2 py-1 text-xs text-right total-with-gst" readonly>
                </div>
            </td>
            <td class="px-2 py-1 text-center"><button type="button" onclick="removeRow(this)" class="text-red-600">&times;</button></td>
        </tr>
    </template>

    <script>
        let rowIndex = 0;

        function addItemRow() {
            const template = document.getElementById('itemRowTemplate');
            const clone = template.content.cloneNode(true);
            const tbody = document.getElementById('itemsBody');

            // Replace INDEX placeholder and SR number
            const html = clone.firstElementChild.outerHTML.replace(/INDEX/g, rowIndex).replace('SR', (rowIndex+1));
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

            row.querySelector('.total-with-gst').value = (totalAfter + gstAmount).toFixed(2);

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
            const cgst = (totalGst/2);
            const sgst = (totalGst/2);
            document.getElementById('summaryCGST').innerText = '₹ ' + cgst.toFixed(2);
            document.getElementById('summarySGST').innerText = '₹ ' + sgst.toFixed(2);
            document.getElementById('summaryIGST').innerText = '₹ ' + (0).toFixed(2);

            document.getElementById('netAmount').innerText = '₹ ' + (totalAmount + totalGst + parseFloat(document.getElementById('roundOff').value || 0)).toFixed(2);
        }

        function calculateNet() {
            calculateAll();
        }

        document.addEventListener('DOMContentLoaded', () => {
            addItemRow();
        });
    </script>
@endsection