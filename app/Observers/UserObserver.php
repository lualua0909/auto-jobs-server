<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the post "saving" event.
     *
     * @param  \App\User  $post
     * @return void
     */
    public function saving(User $user)
    {
        if (isset($user->is_employer) && $user->is_employer == 1) {
            $user->role = 'employer';
            $user->assignRole('employer');
        } else {
            $user->role = 'user';
            $user->assignRole('user');
        }
    }
}
