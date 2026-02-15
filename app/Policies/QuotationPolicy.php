<?php

namespace App\Policies;

use App\Models\Quotation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function view(User $user, Quotation $quotation)
    {
        return $user->role === 'admin' || $user->id === $quotation->created_by;
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function update(User $user, Quotation $quotation)
    {
        if ($user->role === 'admin') return true;
        if ($user->role === 'sales') {
            return $user->id === $quotation->created_by && in_array($quotation->status, ['draft','sent']);
        }
        return false;
    }

    public function delete(User $user, Quotation $quotation)
    {
        return $user->role === 'admin';
    }

    public function duplicate(User $user, Quotation $quotation)
    {
        return in_array($user->role, ['admin','sales']) && ($user->role === 'admin' || $user->id === $quotation->created_by);
    }
}
