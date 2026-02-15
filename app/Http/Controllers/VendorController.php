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

        return redirect()->route('vendors.index')->with('success','Vendor created.');
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

        return redirect()->route('vendors.index')->with('success','Vendor updated.');
    }

    public function destroy(Vendor $vendor)
    {
        $this->authorize('delete', $vendor);
        $vendor->delete();
        return redirect()->route('vendors.index')->with('success','Vendor deleted.');
    }
}
