<?php

namespace App\Http\Controllers;

use App\Models\HsnCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HsnCodeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\HsnCode::class, 'hsn_code');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', HsnCode::class);

        $query = HsnCode::query();
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('code', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%");
        }

        $hsns = $query->latest()->paginate(25)->withQueryString();
        return view('hsn_codes.index', compact('hsns'));
    }

    public function create()
    {
        $this->authorize('create', HsnCode::class);
        return view('hsn_codes.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', HsnCode::class);

        $data = $request->validate([
            'code' => 'required|string|max:64|unique:hsn_codes,code',
            'description' => 'nullable|string',
            'gst_rate' => 'required|numeric|min:0',
        ]);

        $data['created_by'] = Auth::id();

        HsnCode::create($data);

        return redirect()->route('hsn-codes.index')->with('success','HSN code added.');
    }

    public function show(HsnCode $hsn_code)
    {
        $this->authorize('view', $hsn_code);
        return view('hsn_codes.show', ['hsn' => $hsn_code]);
    }

    public function edit(HsnCode $hsn_code)
    {
        $this->authorize('update', $hsn_code);
        return view('hsn_codes.edit', compact('hsn_code'));
    }

    public function update(Request $request, HsnCode $hsn_code)
    {
        $this->authorize('update', $hsn_code);

        $data = $request->validate([
            'code' => 'required|string|max:64|unique:hsn_codes,code,'.$hsn_code->id,
            'description' => 'nullable|string',
            'gst_rate' => 'required|numeric|min:0',
        ]);

        $hsn_code->update($data);

        return redirect()->route('hsn-codes.index')->with('success','HSN code updated.');
    }

    public function destroy(HsnCode $hsn_code)
    {
        $this->authorize('delete', $hsn_code);
        $hsn_code->delete();
        return redirect()->route('hsn-codes.index')->with('success','HSN code removed.');
    }
}
