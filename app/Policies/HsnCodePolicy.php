<?php

namespace App\Policies;

use App\Models\HsnCode;
use App\Models\User;

class HsnCodePolicy
{
    public function viewAny(User $user)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function view(User $user, HsnCode $hsn)
    {
        return in_array($user->role, ['admin','sales']);
    }

    public function create(User $user)
    {
        return $user->role === 'admin';
    }

    public function update(User $user, HsnCode $hsn)
    {
        return $user->role === 'admin';
    }

    public function delete(User $user, HsnCode $hsn)
    {
        return $user->role === 'admin';
    }
}
