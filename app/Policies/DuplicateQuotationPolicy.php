<?php

namespace App\Policies;

use App\Models\DuplicateQuotation;
use App\Models\User;

class DuplicateQuotationPolicy
{
    public function viewAny(User $user)
    {
        return $user->role === 'admin';
    }

    public function view(User $user, DuplicateQuotation $dq)
    {
        return $user->role === 'admin';
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, DuplicateQuotation $dq)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, DuplicateQuotation $dq)
    {
        return $user->role === 'admin';
    }
}
