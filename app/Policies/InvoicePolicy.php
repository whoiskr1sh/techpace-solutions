<?php

namespace App\Policies;

use App\Models\Invoice;
use App\Models\User;
use App\Models\Setting;

class InvoicePolicy
{
    protected function invoicesVisibleForSales()
    {
        return Setting::get('invoices_visible_for_sales', '1') === '1';
    }

    public function viewAny(User $user)
    {
        if ($user->role === 'admin') return true;
        return $user->role === 'sales' && $this->invoicesVisibleForSales();
    }

    public function view(User $user, Invoice $invoice)
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'sales' && $this->invoicesVisibleForSales()) {
            return $invoice->created_by == $user->id;
        }
        return false;
    }

    public function create(User $user)
    {
        if ($user->role === 'admin') return true;
        return $user->role === 'sales' && $this->invoicesVisibleForSales();
    }

    public function update(User $user, Invoice $invoice)
    {
        if ($user->role === 'admin') return true;
        return $user->role === 'sales' && $this->invoicesVisibleForSales() && $invoice->created_by == $user->id;
    }

    public function delete(User $user, Invoice $invoice)
    {
        return $user->role === 'admin';
    }
}
