<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GlobalDataExport;
use App\Imports\GlobalDataImport;

class DataManagementController extends Controller
{
    public function exportAll()
    {
        $filename = 'data_export_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new GlobalDataExport, $filename);
    }

    public function importAll(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new GlobalDataImport, $request->file('file'));

        return redirect()->back()->with('success', 'All data imported successfully.');
    }
}
