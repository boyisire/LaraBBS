<?php

namespace App\Observers;

use App\Models\User;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class UserObserver
{
    public function creating(User $user)
    {
        //
    }

    public function updating(User $user)
    {
        //
    }

    public function saving(User $user)
    {
        if (empty($user->avatar)){
            $user->avatar = 'https://www.google.co.jp/images/branding/googlelogo/2x/googlelogo_color_120x44dp.png';;
        }
    }
}