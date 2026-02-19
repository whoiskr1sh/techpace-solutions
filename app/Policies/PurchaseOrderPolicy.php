<?php

namespace App\Policies;

use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PurchaseOrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function view(User $user, PurchaseOrder $po)
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function create(User $user)
    {
        // Only admin creates POs in this workflow
        return $user->role === 'admin';
    }

    public function update(User $user, PurchaseOrder $po)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, PurchaseOrder $po)
    {
        return $user->role === 'admin';
    }
}
