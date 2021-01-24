<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\APIController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerProductController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //
        $products = $buyer->transactions()->with('product')->get()->pluck('product');

        return $this->showAll($products);
    }

    
}
