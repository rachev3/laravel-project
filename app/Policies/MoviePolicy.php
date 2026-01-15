<?php

namespace App\Policies;

use App\Models\Movie;
use App\Models\User;

class MoviePolicy
{
    public function updatePoster(User $user, Movie $movie): bool
    {
        return (bool) $user->is_admin;
    }
}

