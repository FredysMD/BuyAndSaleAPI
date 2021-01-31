<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\APIController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerTransactionController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        //
        $transactions = $seller->products()
                        ->whereHas('transactions')
                        ->with('transactions')
                        ->get()
                        ->pluck('transactions')
                        ->collapse();
        
        return $this->showAll($transactions);
    }

    
}
