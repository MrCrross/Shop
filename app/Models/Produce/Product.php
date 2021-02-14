<?php

namespace App\Models\Produce;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'main_img', 'price', 'views', 'user_id', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function models()
    {
        return $this->hasMany(ProductModel::class);
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    public function details()
    {
        return $this->belongsToMany(Detail::class)->
                      select('name', 'description', 'value');
    }

    public function hasModel(ProductModel $productModel)
    {
        return $this->id == $productModel->product_id;
    }

    /**
     * @return bool
     */
    public function increaseViews()
    {
        $this->views++;

        return $this->save();
    }

    public function paginateComments()
    {
        $comments = $this->comments()->
                           where('reply_review_id', '=', null)->
                           where('reply_comment_id', '=', null)->
                           paginate(ProductComment::LIMIT);

        foreach($comments as $comment)
        {
            $comment->reply_comments = $comment->firstReplyComment();
        }

        return $comments;
    }

    public static function firstWithRelations($id, $with = ['category', 'models', 'reviews', 'comments', 'images', 'videos', 'details'])
    {
        return self::with($with)->
                     where('id', $id)->
                     firstOrFail();
    }
}
