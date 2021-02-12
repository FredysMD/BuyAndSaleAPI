<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use App\Models\Seller;

class SellerController extends APIController
{   

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sellers = Seller::has('products')->get();

        return $this->showAll($sellers);
    }

    
    public function show(Seller $seller)
    {

        return $this->showOne($seller);
    }

    
}
