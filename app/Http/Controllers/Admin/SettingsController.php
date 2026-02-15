<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function edit()
    {
        $visible = Setting::get('invoices_visible_for_sales', '1');
        return view('admin.settings', ['invoices_visible_for_sales' => $visible]);
    }

    public function update(Request $request)
    {
        $val = $request->has('invoices_visible_for_sales') ? '1' : '0';
        Setting::set('invoices_visible_for_sales', $val);
        return redirect()->route('admin.settings.edit')->with('success','Settings updated.');
    }
}
