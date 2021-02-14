<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    public static function findByName($name)
    {
        return self::where('name', '=', $name)->first();
    }
}
