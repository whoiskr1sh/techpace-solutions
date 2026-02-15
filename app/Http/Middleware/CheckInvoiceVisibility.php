<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Setting;

class CheckInvoiceVisibility
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // If user is sales and invoices visibility is disabled, block access
        if ($user->role === 'sales' && Setting::get('invoices_visible_for_sales', '1') !== '1') {
            return abort(403, 'Unauthorized. Invoices are not visible to sales users.');
        }

        return $next($request);
    }
}
