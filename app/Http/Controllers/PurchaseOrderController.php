<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Vendor;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\PurchaseOrder::class, 'purchase_order');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', PurchaseOrder::class);

        $query = PurchaseOrder::with(['vendor','salesOrder']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('po_number', 'like', "%{$q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->input('vendor_id'));
        }

        $pos = $query->latest()->paginate(15)->withQueryString();

        $vendors = Vendor::active()->get();

        return view('purchase_orders.index', compact('pos','vendors'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', PurchaseOrder::class);

        $vendors = Vendor::active()->get();
        $salesOrders = SalesOrder::latest()->limit(50)->get();

        return view('purchase_orders.create', compact('vendors','salesOrders'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', PurchaseOrder::class);

        $data = $request->validate([
            'po_number' => 'required|string|max:64|unique:purchase_orders,po_number',
            'vendor_id' => 'required|exists:vendors,id',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,ordered,received,cancelled',
            'notes' => 'nullable|string',
        ]);

        $data['created_by'] = Auth::id();

        PurchaseOrder::create($data);

        return redirect()->route('purchase-orders.index')->with('success','Purchase Order created.');
    }

    public function show(PurchaseOrder $purchase_order)
    {
        $this->authorize('view', $purchase_order);
        return view('purchase_orders.show', ['po' => $purchase_order->load(['vendor','salesOrder'])]);
    }

    public function edit(PurchaseOrder $purchase_order)
    {
        $this->authorize('update', $purchase_order);

        $vendors = Vendor::active()->get();
        $salesOrders = SalesOrder::latest()->limit(50)->get();

        return view('purchase_orders.edit', compact('purchase_order','vendors','salesOrders'));
    }

    public function update(Request $request, PurchaseOrder $purchase_order)
    {
        $this->authorize('update', $purchase_order);

        $data = $request->validate([
            'po_number' => 'required|string|max:64|unique:purchase_orders,po_number,'.$purchase_order->id,
            'vendor_id' => 'required|exists:vendors,id',
            'sales_order_id' => 'nullable|exists:sales_orders,id',
            'order_date' => 'required|date',
            'expected_date' => 'nullable|date',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,ordered,received,cancelled',
            'notes' => 'nullable|string',
        ]);

        $purchase_order->update($data);

        return redirect()->route('purchase-orders.index')->with('success','Purchase Order updated.');
    }

    public function destroy(PurchaseOrder $purchase_order)
    {
        $this->authorize('delete', $purchase_order);
        $purchase_order->delete();
        return redirect()->route('purchase-orders.index')->with('success','Purchase Order deleted.');
    }
}
