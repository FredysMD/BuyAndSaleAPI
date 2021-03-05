<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Comment $comment)
    {
        return [
            'identity' => (int)$comment->id,
            'comment' => (string)$comment->content,
            'comment_root' => (int)$comment->comment_parent_id,
            'user' => (int)$comment->user_id,
            'product' => (int)$comment->product_id,
            'createdAt' => (string)$comment->created_at,
            'updatedAt' => (string)$comment->updated_at,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identity' => 'id',
            'comment' => 'content',
            'comment_root' => 'comment_parent_id',
            'user' => 'user_id',
            'product' => 'product_id',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
           'id' => 'identity',
           'content' => 'comment',
           'comment_parent_id' => 'comment_root',
           'user_id' => 'user',
           'product_id' => 'product',
           'created_at' =>'createdAt',
           'updated_at' =>'updatedAt',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
