<?php

namespace App\Traits;

use App\User;

trait BelongsToUser
{
    /**
     * Gets the user model.
     *
     * @return App\User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
