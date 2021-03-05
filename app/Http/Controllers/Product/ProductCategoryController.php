<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\APIController;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductCategoryController extends APIController
{   

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        $categories = $product->categories;

        return $this->showAll($categories);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, Category $category)
    {
        // sync attach - many-to-many relational
        $product->categories()->syncWithoutDetaching([$category->id]);
        
        return $this->showAll($product->categories);

    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Category $category)
    {
        //
        if(!$product->categories()->find($category->id))
            return $this->errorResponse("La categoria no se encuentra asociadad al producto", 405);

        $product->categories()->detach([$category->id]);

        return $this->showAll($product->categories);

    }

}
