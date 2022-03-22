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
    }
}
