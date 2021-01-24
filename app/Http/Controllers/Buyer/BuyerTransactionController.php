<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\APIController;
use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerTransactionController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Buyer $buyer)
    {
        //
        $transactions = $buyer->transactions;

        return $this->showAll($transactions);
    }

    
}
