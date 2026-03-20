<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\SalesOrder::class, 'sales_order');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', SalesOrder::class);

        $query = SalesOrder::with(['quotation', 'creator']);

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
                $q2->where('so_number', 'like', "%{$q}%")
                    ->orWhereHas('quotation', function ($q3) use ($q) {
                        $q3->where('customer_name', 'like', "%{$q}%");
                    });
            });
        }



        if ($request->filled('export')) {
            $format = $request->input('export');
            $items = $query->latest()->get();
            if ($format === 'csv') {
                $filename = 'sales_orders_' . now()->format('Ymd_His') . '.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                ];

                $columns = ['SO#', 'Quotation', 'Customer', 'Total', 'Status', 'Created By', 'Created At'];

                $callback = function () use ($items, $columns) {
                    $handle = fopen('php://output', 'w');
                    fputcsv($handle, $columns);
                    foreach ($items as $it) {
                        fputcsv($handle, [
                            $it->so_number,
                            $it->quotation?->quotation_number,
                            $it->quotation?->customer_name,
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
                    $pdf = \PDF::loadView('sales_orders.export_pdf', $data);
                    return $pdf->stream('sales_orders.pdf');
                }
                return view('sales_orders.export_pdf', $data);
            }
        }

        $salesOrders = $query->latest()->paginate(15)->withQueryString();
        $users = User::select('id', 'name')->get();

        return view('sales_orders.index', compact('salesOrders', 'users'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', SalesOrder::class);

        $quotations = Quotation::query();

        $quotations = $quotations->whereNull('deleted_at')->get();

        return view('sales_orders.create', compact('quotations'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', SalesOrder::class);

        $data = $request->validate([
            'so_number' => 'required|string|unique:sales_orders,so_number',
            'quotation_id' => 'required|exists:quotations,id',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,dispatched,completed',
        ]);



        $data['created_by'] = Auth::id();

        SalesOrder::create($data);

        return redirect()->route('sales-orders.index')->with('success', 'Sales Order created.');
    }

    public function show(SalesOrder $salesOrder)
    {
        $this->authorize('view', $salesOrder);
        return view('sales_orders.show', compact('salesOrder'));
    }

    public function edit(SalesOrder $salesOrder)
    {
        $this->authorize('update', $salesOrder);

        return view('sales_orders.edit', compact('salesOrder'));
    }

    public function update(Request $request, SalesOrder $salesOrder)
    {
        $this->authorize('update', $salesOrder);

        $data = $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,dispatched,completed',
        ]);

        $salesOrder->update($data);

        return redirect()->route('sales-orders.index')->with('success', 'Sales Order updated.');
    }

    public function downloadPdf(SalesOrder $salesOrder)
    {
        $this->authorize('view', $salesOrder);
        
        $salesOrder->load(['quotation.items']);

        if (class_exists('\PDF')) {
            $pdf = \PDF::loadView('sales_orders.pdf', ['salesOrder' => $salesOrder]);
            return $pdf->stream('SO_' . $salesOrder->so_number . '.pdf');
        }

        return view('sales_orders.pdf', ['salesOrder' => $salesOrder]);
    }

    public function destroy(SalesOrder $salesOrder)
    {
        $this->authorize('delete', $salesOrder);
        $salesOrder->delete();
        return redirect()->route('sales-orders.index')->with('success', 'Sales Order deleted.');
    }
}
