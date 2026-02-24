<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\Quotation::class, 'quotation');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Quotation::class);

        $query = Quotation::with('creator');

        // filters: q, status, user_id, date_from, date_to
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('user_id')) {
            $query->where('created_by', $request->input('user_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function ($q2) use ($q) {
                $q2->where('quotation_number', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%");
            });
        }



        // Export handling
        if ($request->filled('export')) {
            $format = $request->input('export');
            $items = $query->latest()->get();
            if ($format === 'csv') {
                $filename = 'quotations_' . now()->format('Ymd_His') . '.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                ];

                $columns = ['Quotation#', 'Customer', 'Email', 'Total', 'Status', 'Created By', 'Created At'];

                $callback = function () use ($items, $columns) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, $columns);
                    foreach ($items as $it) {
                        fputcsv($handle, [
                            $it->quotation_number,
                            $it->customer_name,
                            $it->customer_email,
                            number_format($it->total_amount, 2),
                            $it->status,
                            $it->creator?->name,
                            $it->created_at->toDateTimeString(),
                        ]);
                    }
                    fclose($handle);
                };

                return response()->stream($callback, 200, $headers);
            }

            if ($format === 'pdf') {
                $data = ['items' => $query->latest()->get()];
                if (class_exists('\PDF')) {
                    $pdf = \PDF::loadView('quotations.export_pdf', $data);
                    return $pdf->stream('quotations.pdf');
                }
                // fallback: return HTML view
                return view('quotations.export_pdf', $data);
            }
        }

        $quotations = $query->latest()->paginate(15)->withQueryString();
        $users = User::select('id', 'name')->get();

        return view('quotations.index', compact('quotations', 'users'));
    }

    public function create()
    {
        $this->authorize('create', Quotation::class);
        return view('quotations.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Quotation::class);

        $data = $request->validate([
            'quotation_number' => 'required|string|unique:quotations,quotation_number',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'source_of_inquiry_id' => 'nullable|exists:source_of_inquiries,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected,converted',
            'items' => 'required|array|min:1',
            // legacy fields
            'items.*.make' => 'nullable|string',
            'items.*.model_no' => 'nullable|string',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.delivery_time' => 'nullable|string',
            'items.*.remarks' => 'nullable|string',
            // new form fields
            'items.*.name' => 'nullable|string',
            'items.*.unit' => 'nullable|string',
            'items.*.qty' => 'nullable|integer|min:1',
            'items.*.rate' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:percent,fixed',
            'items.*.discount_value' => 'nullable|numeric|min:0',
            'items.*.gst_percent' => 'nullable|numeric|min:0',
            'is_usd' => 'nullable|boolean',
        ]);

        $currency = $request->has('is_usd') && $request->is_usd ? 'USD' : 'INR';

        // Calculate total amount from items to be safe
        $totalAmount = 0;
        foreach ($data['items'] as $item) {
            // map values from either legacy or new form
            $unitPrice = $item['unit_price'] ?? $item['rate'] ?? 0;
            $qty = $item['quantity'] ?? $item['qty'] ?? 0;

            // determine discount
            $discountPercent = null;
            $discountFixed = null;
            if (isset($item['discount'])) {
                $discountPercent = $item['discount'];
            } elseif (isset($item['discount_type']) && isset($item['discount_value'])) {
                if ($item['discount_type'] === 'percent') {
                    $discountPercent = $item['discount_value'];
                } else {
                    $discountFixed = $item['discount_value'];
                }
            }

            if ($discountPercent !== null) {
                $unitDiscPrice = $unitPrice - ($unitPrice * $discountPercent / 100);
            } elseif ($discountFixed !== null && $qty > 0) {
                $unitDiscPrice = max(0, $unitPrice - ($discountFixed / $qty));
            } else {
                $unitDiscPrice = $unitPrice;
            }

            $totalAmount += $unitDiscPrice * $qty;
        }

        $quotation = Quotation::create([
            'quotation_number' => $data['quotation_number'],
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'source_of_inquiry_id' => $data['source_of_inquiry_id'],
            'notes' => $data['notes'],
            'status' => $data['status'],
            'currency' => $currency,
            'total_amount' => $totalAmount,
            'created_by' => Auth::id(),
        ]);

        foreach ($data['items'] as $item) {
            $unitPrice = $item['unit_price'] ?? $item['rate'] ?? 0;
            $qty = $item['quantity'] ?? $item['qty'] ?? 0;

            // determine discount
            $discountPercent = 0;
            $discountFixed = null;
            if (isset($item['discount'])) {
                $discountPercent = $item['discount'];
            } elseif (isset($item['discount_type']) && isset($item['discount_value'])) {
                if ($item['discount_type'] === 'percent') {
                    $discountPercent = $item['discount_value'];
                } else {
                    $discountFixed = $item['discount_value'];
                }
            }

            if ($discountPercent) {
                $unitDiscPrice = $unitPrice - ($unitPrice * $discountPercent / 100);
            } elseif ($discountFixed !== null && $qty > 0) {
                $unitDiscPrice = max(0, $unitPrice - ($discountFixed / $qty));
            } else {
                $unitDiscPrice = $unitPrice;
            }

            $totalPrice = $unitDiscPrice * $qty;

            $quotation->items()->create([
                'make' => $item['make'] ?? $item['name'] ?? null,
                'model_no' => $item['model_no'] ?? null,
                'unit_price' => $unitPrice,
                'discount' => $discountPercent,
                'unit_discounted_price' => $unitDiscPrice,
                'quantity' => $qty,
                'total_price' => $totalPrice,
                'delivery_time' => $item['delivery_time'] ?? null,
                'remarks' => $item['remarks'] ?? null,
            ]);
        }

        return redirect()->route('quotations.index')->with('success', 'Quotation created.');
    }

    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation);
        return view('quotations.show', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $this->authorize('update', $quotation);
        return view('quotations.edit', compact('quotation'));
    }

    public function update(Request $request, Quotation $quotation)
    {
        $this->authorize('update', $quotation);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:30',
            'source_of_inquiry_id' => 'nullable|exists:source_of_inquiries,id',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,sent,accepted,rejected,converted',
            'items' => 'required|array|min:1',
            // legacy
            'items.*.make' => 'nullable|string',
            'items.*.model_no' => 'nullable|string',
            'items.*.unit_price' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'items.*.quantity' => 'nullable|integer|min:1',
            'items.*.delivery_time' => 'nullable|string',
            'items.*.remarks' => 'nullable|string',
            // new
            'items.*.name' => 'nullable|string',
            'items.*.unit' => 'nullable|string',
            'items.*.qty' => 'nullable|integer|min:1',
            'items.*.rate' => 'nullable|numeric|min:0',
            'items.*.discount_type' => 'nullable|in:percent,fixed',
            'items.*.discount_value' => 'nullable|numeric|min:0',
            'items.*.gst_percent' => 'nullable|numeric|min:0',
            'is_usd' => 'nullable|boolean',
        ]);

        $currency = $request->has('is_usd') && $request->is_usd ? 'USD' : 'INR';

        // Calculate total
        $totalAmount = 0;
        foreach ($data['items'] as $item) {
            $unitPrice = $item['unit_price'] ?? $item['rate'] ?? 0;
            $qty = $item['quantity'] ?? $item['qty'] ?? 0;

            $discountPercent = null;
            $discountFixed = null;
            if (isset($item['discount'])) {
                $discountPercent = $item['discount'];
            } elseif (isset($item['discount_type']) && isset($item['discount_value'])) {
                if ($item['discount_type'] === 'percent') {
                    $discountPercent = $item['discount_value'];
                } else {
                    $discountFixed = $item['discount_value'];
                }
            }

            if ($discountPercent !== null) {
                $unitDiscPrice = $unitPrice - ($unitPrice * $discountPercent / 100);
            } elseif ($discountFixed !== null && $qty > 0) {
                $unitDiscPrice = max(0, $unitPrice - ($discountFixed / $qty));
            } else {
                $unitDiscPrice = $unitPrice;
            }

            $totalAmount += $unitDiscPrice * $qty;
        }

        $quotation->update([
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'],
            'source_of_inquiry_id' => $data['source_of_inquiry_id'],
            'notes' => $data['notes'],
            'status' => $data['status'],
            'currency' => $currency,
            'total_amount' => $totalAmount,
        ]);

        // Sync items: Delete all and recreate
        $quotation->items()->delete();

        foreach ($data['items'] as $item) {
            $unitPrice = $item['unit_price'] ?? $item['rate'] ?? 0;
            $qty = $item['quantity'] ?? $item['qty'] ?? 0;

            $discountPercent = 0;
            $discountFixed = null;
            if (isset($item['discount'])) {
                $discountPercent = $item['discount'];
            } elseif (isset($item['discount_type']) && isset($item['discount_value'])) {
                if ($item['discount_type'] === 'percent') {
                    $discountPercent = $item['discount_value'];
                } else {
                    $discountFixed = $item['discount_value'];
                }
            }

            if ($discountPercent) {
                $unitDiscPrice = $unitPrice - ($unitPrice * $discountPercent / 100);
            } elseif ($discountFixed !== null && $qty > 0) {
                $unitDiscPrice = max(0, $unitPrice - ($discountFixed / $qty));
            } else {
                $unitDiscPrice = $unitPrice;
            }

            $totalPrice = $unitDiscPrice * $qty;

            $quotation->items()->create([
                'make' => $item['make'] ?? $item['name'] ?? null,
                'model_no' => $item['model_no'] ?? null,
                'unit_price' => $unitPrice,
                'discount' => $discountPercent,
                'unit_discounted_price' => $unitDiscPrice,
                'quantity' => $qty,
                'total_price' => $totalPrice,
                'delivery_time' => $item['delivery_time'] ?? null,
                'remarks' => $item['remarks'] ?? null,
            ]);
        }

        return redirect()->route('quotations.index')->with('success', 'Quotation updated.');
    }

    public function destroy(Quotation $quotation)
    {
        $this->authorize('delete', $quotation);
        $quotation->delete();
        return redirect()->route('quotations.index')->with('success', 'Quotation deleted.');
    }
}
