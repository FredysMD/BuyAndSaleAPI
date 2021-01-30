<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\APIController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryProductController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        //
        $products = $category->products;
        
        return $this->showAll($products);
    }

}
