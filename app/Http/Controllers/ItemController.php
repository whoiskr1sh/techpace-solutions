<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::orderBy('item_name')->get();

        if (request()->wantsJson()) {
            return response()->json($items);
        }

        return view('items.index', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type_of_item' => 'required|in:SERVICE,TRADING',
            'group_of_item' => 'nullable|string|max:255',
            'item_name' => 'required|string|max:255',
            'item_description' => 'nullable|string',
            'primary_unit' => 'nullable|string|max:255',
            'is_freez' => 'boolean',
            'gst_percent' => 'nullable|numeric|min:0|max:100',
            'igst_percent' => 'nullable|numeric|min:0|max:100',
            'is_machine' => 'boolean',
            'hsn_code' => 'nullable|string|max:255',
            'account_group' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('items', 'public');
        }

        $item = Item::create([
            'type_of_item' => $validated['type_of_item'],
            'group_of_item' => $validated['group_of_item'] ?? null,
            'item_name' => $validated['item_name'],
            'item_description' => $validated['item_description'] ?? null,
            'primary_unit' => $validated['primary_unit'] ?? null,
            'is_freez' => $request->has('is_freez'),
            'gst_percent' => $validated['gst_percent'] ?? 0,
            'igst_percent' => $validated['igst_percent'] ?? 0,
            'is_machine' => $request->has('is_machine'),
            'hsn_code' => $validated['hsn_code'] ?? null,
            'account_group' => $validated['account_group'] ?? null,
            'photo' => $photoPath,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'item' => $item,
                'message' => 'Item created successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Item created successfully.');
    }
}
