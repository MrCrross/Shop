<?php

namespace App\Models\Tokens;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    /**
     * @param User $user
     */
    public function isOwner(User $user)
    {
        return $user->id == $this->user_id;
    }

    /**
     * @param string $tokens
     */
    public static function findByToken($token)
    {
        return static::where('token', '=', $token)->first();
    }
}
