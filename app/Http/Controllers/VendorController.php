<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\Vendor::class, 'vendor');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Vendor::class);

        $query = Vendor::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('name', 'like', "%{$q}%")->orWhere('contact_person', 'like', "%{$q}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Export Csv
        if ($request->filled('export') && $request->input('export') === 'csv') {
            if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'sales') {
                abort(403, 'Unauthorized action.');
            }

            $items = $query->latest()->get();
            $filename = 'vendors_' . now()->format('Ymd_His') . '.csv';
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $columns = ['Name', 'Contact Person', 'Email', 'Phone', 'Address', 'GSTIN', 'Status', 'Created At'];

            $callback = function () use ($items, $columns) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, $columns);
                foreach ($items as $item) {
                    fputcsv($handle, [
                        $item->name,
                        $item->contact_person,
                        $item->email,
                        $item->phone,
                        $item->address,
                        $item->gstin,
                        $item->status,
                        $item->created_at->toDateTimeString(),
                    ]);
                }
                fclose($handle);
            };

            return response()->stream($callback, 200, $headers);
        }

        $vendors = $query->latest()->paginate(15)->withQueryString();

        return view('vendors.index', compact('vendors'));
    }

    public function create()
    {
        $this->authorize('create', Vendor::class);
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Vendor::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'gstin' => 'nullable|string|max:64',
            'status' => 'required|in:active,inactive',
        ]);

        $data['created_by'] = Auth::id();

        Vendor::create($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor created.');
    }

    public function show(Vendor $vendor)
    {
        $this->authorize('view', $vendor);
        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        $this->authorize('update', $vendor);
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $this->authorize('update', $vendor);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
            'gstin' => 'nullable|string|max:64',
            'status' => 'required|in:active,inactive',
        ]);

        $vendor->update($data);

        return redirect()->route('vendors.index')->with('success', 'Vendor updated.');
    }

    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success', 'Vendor deleted.');
    }

    public function import(Request $request)
    {
        if (Auth::user()->role !== 'admin' && Auth::user()->role !== 'sales') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');

        // Skip header
        fgetcsv($handle);

        $count = 0;
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            // Expected columns: Name, Contact Person, Email, Phone, Address, GSTIN, Status
            // Index: 0, 1, 2, 3, 4, 5, 6
            if (count($row) < 7)
                continue;

            Vendor::create([
                'name' => $row[0],
                'contact_person' => $row[1] ?? null,
                'email' => $row[2] ?? null,
                'phone' => $row[3] ?? null,
                'address' => $row[4] ?? null,
                'gstin' => $row[5] ?? null,
                'status' => in_array($row[6], ['active', 'inactive']) ? $row[6] : 'active',
                'created_by' => Auth::id(),
            ]);
            $count++;
        }

        fclose($handle);

        return redirect()->route('vendors.index')->with('success', "Imported {$count} vendors successfully.");
    }
}
