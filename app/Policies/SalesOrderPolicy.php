<?php

namespace App\Policies;

use App\Models\SalesOrder;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SalesOrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function view(User $user, SalesOrder $salesOrder)
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function create(User $user)
    {
        return in_array($user->role, ['admin', 'sales']);
    }

    public function update(User $user, SalesOrder $salesOrder)
    {
        if ($user->role === 'admin')
            return true;
        if ($user->role === 'sales') {
            return $user->id === $salesOrder->created_by && in_array($salesOrder->status, ['pending', 'confirmed']);
        }
        return false;
    }

    public function delete(User $user, SalesOrder $salesOrder)
    {
        return $user->role === 'admin';
    }
}
