<?php

namespace App\Policies;

use App\Models\PelamarProfile;
use App\Models\User;

class PelamarProfilePolicy
{
    public function view(User $user, PelamarProfile $profile): bool
    {
        return (int)$profile->user_id === (int)$user->id;
    }

    public function update(User $user, PelamarProfile $profile): bool
    {
        return (int)$profile->user_id === (int)$user->id;
    }
}
