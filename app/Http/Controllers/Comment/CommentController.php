<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends APIController
{
   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = Comment::all();
        return $this->showAll($comments);

    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $Comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
        return $this->showOne($comment);
    }


    
}
