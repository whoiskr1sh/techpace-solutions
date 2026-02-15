<?php

namespace App\Http\Controllers;

use App\Models\ProformaInvoice;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProformaInvoiceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\ProformaInvoice::class, 'proforma_invoice');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', ProformaInvoice::class);

        $query = ProformaInvoice::with('salesOrder');

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('pi_number', 'like', "%{$q}%")->orWhere('customer_name', 'like', "%{$q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $pis = $query->latest()->paginate(15)->withQueryString();

        return view('proforma_invoices.index', compact('pis'));
    }

    public function create()
    {
        $this->authorize('create', ProformaInvoice::class);
        $salesOrders = SalesOrder::latest()->limit(50)->get();
        return view('proforma_invoices.create', compact('salesOrders'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', ProformaInvoice::class);

        $data = $request->validate([
            'pi_number' => 'required|string|max:64|unique:proforma_invoices,pi_number',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_name' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,issued,cancelled',
        ]);

        $data['created_by'] = Auth::id();

        ProformaInvoice::create($data);

        return redirect()->route('proforma-invoices.index')->with('success','Proforma Invoice created.');
    }

    public function show(ProformaInvoice $proforma_invoice)
    {
        $this->authorize('view', $proforma_invoice);
        return view('proforma_invoices.show', ['pi' => $proforma_invoice->load('salesOrder')]);
    }

    public function edit(ProformaInvoice $proforma_invoice)
    {
        $this->authorize('update', $proforma_invoice);
        $salesOrders = SalesOrder::latest()->limit(50)->get();
        return view('proforma_invoices.edit', compact('proforma_invoice','salesOrders'));
    }

    public function update(Request $request, ProformaInvoice $proforma_invoice)
    {
        $this->authorize('update', $proforma_invoice);

        $data = $request->validate([
            'pi_number' => 'required|string|max:64|unique:proforma_invoices,pi_number,'.$proforma_invoice->id,
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'customer_name' => 'nullable|string|max:255',
            'issue_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'status' => 'required|in:draft,issued,cancelled',
        ]);

        $proforma_invoice->update($data);

        return redirect()->route('proforma-invoices.index')->with('success','Proforma Invoice updated.');
    }

    public function destroy(ProformaInvoice $proforma_invoice)
    {
        $this->authorize('delete', $proforma_invoice);
        $proforma_invoice->delete();
        return redirect()->route('proforma-invoices.index')->with('success','Proforma Invoice deleted.');
    }
}
