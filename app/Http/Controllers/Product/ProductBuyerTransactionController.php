<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\APIController;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Transformers\TransactionTransformer;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;


class ProductBuyerTransactionController extends APIController
{
    
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        //
        $rules = [
            "quantity" => "required|integer|min:1"
        ];

        $this->validate($request, $rules);

        if($buyer->id == $product->seller_id)
            return $this->errorResponse("El propietario del producto no puede ser el compardor del mismo.", 409);
        
        if(!$buyer->isVerified())
            return $this->errorResponse("El comprador debe estar verificado.", 409);

        if(!$product->seller->isVerified())
            return $this->errorResponse("El vendedor debe estar verificado.", 409);

        if(!$product->isEnable())
            return $this->errorResponse("El producto no esta disponible.", 409);
        
        if($product->quantity < $request->quantity)
            return $this->errorResponse("Supera la cantidad del stock.", 409);
        
        // Almacenar una o multples transaction en la base de datos

        return DB::transaction(function() use($request, $product, $buyer){
            
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'total' => ($request->quantity * floatval($product->price)),
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction, 201);
        });

    }   

   
}
