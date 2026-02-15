<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function view(User $user, Vendor $vendor)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, Vendor $vendor)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, Vendor $vendor)
    {
        return $user->role === 'admin';
    }
}
