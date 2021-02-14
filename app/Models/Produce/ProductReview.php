<?php

namespace App\Models\Produce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductReview extends Model
{
    use HasFactory;

    const LIMIT = 10;
    const MIN_RATING = 1;
    const MAX_RATING = 5;

    protected $fillable = [
        'text', 'rating', 'user_id', 'product_id'
    ];

    public static function total(Product $product)
    {
        $ratingCounts = [];
        for($rating = self::MIN_RATING; $rating <= self::MAX_RATING; $rating++)
        {
            $ratingCounts[$rating] = $product->reviews()->
                                               where('rating', '=', $rating)->
                                               count('id');
        }

        return [
            'avg' => $product->reviews()->avg('rating'),
            'total' => $product->reviews()->count('id'),
            'ratings_counts' => $ratingCounts
        ];
    }
}
