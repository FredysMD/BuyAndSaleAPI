<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\APIController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCommentController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        $comments = $product->comments;

        return $this->showAll($comments);
    }

   
}
