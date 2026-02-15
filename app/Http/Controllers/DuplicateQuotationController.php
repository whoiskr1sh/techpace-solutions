<?php

namespace App\Http\Controllers;

use App\Models\DuplicateQuotation;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DuplicateQuotationController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(\App\Models\DuplicateQuotation::class, 'duplicate_quotation');
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', DuplicateQuotation::class);

        $query = DuplicateQuotation::with(['original','duplicate']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->whereHas('original', function($q2) use ($q){ $q2->where('quotation_number','like',"%{$q}%"); })
                  ->orWhereHas('duplicate', function($q2) use ($q){ $q2->where('quotation_number','like',"%{$q}%"); });
        }

        $dqs = $query->latest()->paginate(25)->withQueryString();
        return view('duplicate_quotations.index', compact('dqs'));
    }

    public function show(DuplicateQuotation $duplicate_quotation)
    {
        $this->authorize('view', $duplicate_quotation);
        return view('duplicate_quotations.show', ['dq' => $duplicate_quotation->load(['original','duplicate'])]);
    }

    public function destroy(DuplicateQuotation $duplicate_quotation)
    {
        $this->authorize('delete', $duplicate_quotation);
        $duplicate_quotation->delete();
        return redirect()->route('duplicate-quotations.index')->with('success','Record removed.');
    }

    // Admin helper to create a duplicate record when needed
    public function createFromQuotation(Quotation $quotation)
    {
        $this->authorize('create', DuplicateQuotation::class);

        $new = $quotation->replicate();
        $new->quotation_number = $quotation->quotation_number.'-dup-'.time();
        $new->created_by = Auth::id();
        $new->save();

        $dq = DuplicateQuotation::create([
            'original_quotation_id' => $quotation->id,
            'new_quotation_id' => $new->id,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('quotations.edit', $new)->with('success','Quotation duplicated.');
    }
}
