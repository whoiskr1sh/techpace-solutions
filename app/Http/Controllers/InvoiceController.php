<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Vendor;
use App\Models\SalesOrder;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\Invoice::class, 'invoice');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Invoice::class);

        $query = Invoice::with(['proformaInvoice','salesOrder']);

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
            $query->where('invoice_number', 'like', "%{$q}%")->orWhere('customer_name', 'like', "%{$q}%");
        }

        if ($request->filled('export')) {
            $format = $request->input('export');
            $items = $query->latest()->get();
            if ($format === 'csv') {
                $filename = 'invoices_'.now()->format('Ymd_His').'.csv';
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                ];

                $columns = ['Invoice#','Customer','Total','Status','Created By','Issue Date'];

                $callback = function() use ($items, $columns) {
                    $handle = fopen('php://output','w');
                    fputcsv($handle, $columns);
                    foreach ($items as $it) {
                        fputcsv($handle, [
                            $it->invoice_number,
                            $it->customer_name,
                            number_format($it->total_amount,2),
                            $it->status,
                            $it->creator?->name,
                            optional($it->issue_date)->toDateString(),
                        ]);
                    }
                    fclose($handle);
                };

                return response()->stream($callback, 200, $headers);
            }

            if ($format === 'pdf') {
                $data = ['items' => $query->latest()->get()];
                if (class_exists('\PDF')) {
                    $pdf = \PDF::loadView('invoices.export_pdf', $data);
                    return $pdf->stream('invoices.pdf');
                }
                return view('invoices.export_pdf', $data);
            }
        }

        $invoices = $query->latest()->paginate(15)->withQueryString();
        $users = User::select('id','name')->get();

        return view('invoices.index', compact('invoices','users'));
    }

    public function create()
    {
        $this->authorize('create', Invoice::class);

        $salesOrders = SalesOrder::latest()->limit(50)->get();

        return view('invoices.create', compact('salesOrders'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Invoice::class);

        $data = $request->validate([
            'invoice_number' => 'required|string|max:64|unique:invoices,invoice_number',
            'proforma_invoice_id' => 'nullable|exists:proforma_invoices,id',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_name' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,issued,paid,cancelled',
        ]);

        $data['created_by'] = Auth::id();

        Invoice::create($data);

        return redirect()->route('invoices.index')->with('success','Invoice created.');
    }

    public function show(Invoice $invoice)
    {
        $this->authorize('view', $invoice);
        return view('invoices.show', ['invoice' => $invoice->load(['proformaInvoice','salesOrder'])]);
    }

    public function edit(Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $salesOrders = SalesOrder::latest()->limit(50)->get();

        return view('invoices.edit', compact('invoice','salesOrders'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $this->authorize('update', $invoice);

        $data = $request->validate([
            'invoice_number' => 'required|string|max:64|unique:invoices,invoice_number,'.$invoice->id,
            'proforma_invoice_id' => 'nullable|exists:proforma_invoices,id',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_name' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,issued,paid,cancelled',
        ]);

        $invoice->update($data);

        return redirect()->route('invoices.index')->with('success','Invoice updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return redirect()->route('invoices.index')->with('success','Invoice deleted.');
    }
}
