<?php

namespace App\Policies;

use App\Models\ProformaInvoice;
use App\Models\User;

class ProformaInvoicePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function view(User $user, ProformaInvoice $pi)
    {
        if ($user->role === 'admin') return true;
        return $pi->created_by == $user->id;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function update(User $user, ProformaInvoice $pi)
    {
        if ($user->role === 'admin') return true;
        return $pi->created_by == $user->id;
    }

    public function delete(User $user, ProformaInvoice $pi)
    {
        return $user->role === 'admin';
    }
}
