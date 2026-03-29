<?php

namespace App\Policies;

use App\Models\Habit;
use App\Models\User;

class HabitPolicy
{
    //  voir la liste de ses habitudes
    public function viewAny(User $user): bool
    {
        return true;
    }

    // hab specifique
    public function view(User $user, Habit $habit): bool
    {
        return $user->id === (int)$habit->utilisateur_id;
    }

    // crééer un hab
    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Habit $habit): bool
    {
        return $user->id === (int)$habit->utilisateur_id;
    }


    public function delete(User $user, Habit $habit): bool
    {
        return $user->id === (int)$habit->utilisateur_id;
    }

    public function restore(User $user, Habit $habit): bool
    {
        return $user->id === (int)$habit->utilisateur_id;
    }

    public function forceDelete(User $user, Habit $habit): bool
    {
        return $user->id === (int)$habit->utilisateur_id;
    }
}
