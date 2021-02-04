<?php

namespace App\Http\Controllers\Seller;


use App\Http\Controllers\APIController;
use App\Models\Seller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Seller $seller)
    {
        //
        $products = $seller->products;

        return $this->showAll($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $seller)
    {
        //
        $rules =[
            'name' => 'required',
            'description' =>'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'required|image'
        ];

        $this->validate($request, $rules);

        $data = $request->all();

        $data['status'] = Product::DISABLE_PRODUCT;
        $data['image']  = $request->image->store('');
        $data['seller_id'] = $seller->id;

        $product = Product::create($data);

        return $this->showOne($product, 201);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $seller, Product $product)
    {
        //
        $rules =[
            'status' => 'in: '.Product::DISABLE_PRODUCT, ','.Product::ENABLE_PRODUCT,
            'quantity' => 'integer|min:1',
            'image' => 'image'
        ];

        $this->validate($request, $rules);
        
        $this->validateSeller($seller, $product);

        $product->fill($request->only([
            'name',
            'descrption',
            'quantity',
        ]));

        if($request->has('status')){
            $product->status = $request->status;

            if($product->isEnable() && $product->categories()->count() == 0)
                return $this->errorResponse('El identificador suministrado no concuerda con el del dueño del producto', 409);
        }

        if($request->hasFile('iamge')){
            
            Storage::delete($product->image);

            $product->image = $request->image->store('');

        }

        if($product->isClean())
            return $this->errorResponse('Debes especificar al menos un valor diferente', 422);

        $product->save();

        return $this->showOne($product, 201);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seller $seller, Product $product)
    {
        //
        $this->validateSeller($seller, $product);

        Storage::delete($product->image);

        $product->delete();

        return $this->showOne($product);

    }

    protected function validateSeller(Seller $seller, Product $product)
    {
        
        if($seller->id != $product->seller_id)
           throw new HttpException(422); 
    }
}
