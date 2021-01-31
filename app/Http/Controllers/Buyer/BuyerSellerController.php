<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\APIController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerSellerController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        // operación que va desde el comprador, pasando por: transactions, product y luego a los sellers. Las operaciones de unique y values son para garantizar datos no repetidos y colections con datos vacíos. 
        $sellers = $buyer->transactions()
                ->with('product.seller')
                ->get()
                ->pluck('product.seller')
                ->unique('id')
                ->values();
        
        return $this->showAll($sellers);
    }

}
