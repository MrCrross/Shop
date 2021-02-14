<?php

namespace App\Models\Tokens;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeEmailToken extends Token
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'token'
    ];
}
