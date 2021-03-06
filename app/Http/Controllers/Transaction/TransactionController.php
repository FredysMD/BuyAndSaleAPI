<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\APIController;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $transactions = Transaction::all();
        dd($transactions);
        return $this->showAll($transactions);

    }

    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
        return $this->showOne($transaction);
    }

    
}
