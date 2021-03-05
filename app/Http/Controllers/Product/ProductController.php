<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\APIController;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends APIController
{   

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index','show']);
        $this->middleware('transform.input:' . CategoryTransformer::class)->only(['store','update']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products = Product::all();

        return $this->showAll($products);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
        return $this->showOne($product);
    }

    
}
