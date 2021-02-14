<?php

namespace App\Services;

use App\Models\User;
use App\Models\Tokens\Token;
use App\Models\Tokens\ChangeEmailToken;
use App\Models\Tokens\ChangePasswordToken;

class SecurityService
{
    /**
     * @param User $user
     * @param string $updatableColumn
     * @param mixed $value
     * @param Token|null $token
     */
    private function updateUserData(User $user, $updatableColumn, $value, $token)
    {
        if(!$token || !$token->isOwner($user))
        {
            return false;
        }

        $user->$updatableColumn = $value;
        $user->save();
        $token->delete();

        return true;
    }

    /**
     * @param string $email
     * @param string $token
     */
    public function changeEmail($email, $token)
    {
        $user = User::find(auth()->id());
        $changeEmailToken = ChangeEmailToken::findByToken($token);

        return $this->updateUserData($user, 'email', $email, $changeEmailToken);
    }

    /**
     * @param string $oldPassword
     * @param string $newPassword
     * @param string $token
     */
    public function changePassword($newPassword, $token)
    {
        $user = User::find(auth()->id());
        $changePasswordToken = ChangePasswordToken::findByToken($token);
        return $this->updateUserData($user, 'password', $newPassword, $changePasswordToken);
    }
}
