<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\APIController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionCategoryController extends APIController
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
    public function index(Transaction $transaction)
    {
        //
        $categories = $transaction->product->categories;

        return $this->showAll($categories); 

    }

    
}
