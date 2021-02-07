<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

use App\Models\Product;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identity' => (int)$product->id,
            'title' => (string)$product->name,
            'details' => (string)$product->description,
            'enable' => (string)$product->quantity,
            'status' => (string)$product->status,
            'imagen' => url("img/{$product->image}"),
            'seller' => (int)$product->seller_id,
            'createdAt' => (string)$product->created_at,
            'updatedAt' => (string)$product->updated_at,
        ];
    }
}
