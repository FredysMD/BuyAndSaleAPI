<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\APIController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryTransactionController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Category $category)
    {
        //
        $transactions = $category->products()
                    ->whereHas('transactions') // solo los productos que tengan transactions
                    ->with('transactions')
                    ->get()
                    ->pluck('transactions')
                    ->collapse();

        return $this->showAll($transactions); 
    }

}
