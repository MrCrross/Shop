<?php

namespace App\Models\Tokens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangePasswordToken extends Token
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'token'
    ];
}
