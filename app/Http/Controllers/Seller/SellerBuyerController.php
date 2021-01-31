<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\APIController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerBuyerController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        //
        $buyers = $seller->products()
                  ->whereHas('transactions')
                  ->with('transactions.buyer')
                  ->get()
                  ->pluck('transactions')
                  ->collapse()
                  ->pluck('buyer')
                  ->unique('id')
                  ->values();
        
        return $this->showAll($buyers);
    }

}
