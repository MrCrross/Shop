<?php

namespace App\Models\Produce;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    const LIMIT = 10;
    const REPLY_LIMIT = 3;

    protected $fillable = [
        'text',
        'user_id',
        'product_id',
        'reply_review_id',
        'reply_comment_id'
    ];

    public function replyComments()
    {
        return $this->hasMany(ProductComment::class, 'reply_comment_id');
    }

    public function firstReplyComment()
    {
        return $this->replyComments()->first();
    }

    public function paginateReplyComments()
    {
        return $this->replyComments()->
                      paginate(self::REPLY_LIMIT);
    }
}
