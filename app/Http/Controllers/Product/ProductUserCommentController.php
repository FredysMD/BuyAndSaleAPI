<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Transformers\CommentTransformer;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class ProductUserCommentController extends APIController
{   

    public function __construct()
    {
        $this->middleware('transform.input:' . CommentTransformer::class)->only(['store']);
    }

    public function store(Request $request, Product $product, User $user)
    {
        
        $rules = [ 'comment' => 'required'];

        $this->validate($request, $rules);

        $comment = new Comment();
        $comment->comment_parent_id = $request->comment_root;
        $comment->product_id = $product->id;
        $comment->user_id = $user->id;

        $post->comments()->save($comment);

        return $this->showOne($comment, 201);
        
    }
}
