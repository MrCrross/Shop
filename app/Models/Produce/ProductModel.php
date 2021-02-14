<?php

namespace App\Models\Produce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    use HasFactory;

    public function details()
    {
        return $this->belongsToMany(Detail::class)->
                      select('name', 'description', 'value');
    }
}
