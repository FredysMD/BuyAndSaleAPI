<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\APIController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryBuyerController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        //
        $buyers = $category->products()
                ->whereHas('transactions')
                ->with('transactions.buyer')
                ->get()
                ->pluck('transactions')
                ->collapse()
                ->pluck('buyer')
                ->unique()
                ->values();

        return $this->showAll($buyers);
    }

   
}
