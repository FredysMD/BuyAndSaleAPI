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

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],

                [
                    'rel' => 'products.buyers',
                    'href' => route('products.buyers.index', $product->id),
                ],

                [
                    'rel' => 'products.categories',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'products.sellers',
                    'href' => route('products.sellers.index', $product->id),
                ],
                [
                    'rel' => 'products.transactions',
                    'href' => route('products.transactions.index', $product->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identity' => 'id',
            'title' => 'name',
            'details' => 'description',
            'enable' => 'quantity',
            'status' => 'status',
            'imagen' => 'image',
            'seller' => 'seller_id',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
           'id' => 'identity',
           'name' =>  'title',
           'description' => 'details',
           'quantity' => 'enable',
           'status' => 'status',
           'imagen' => 'image',
           'seller_id' => 'seller',
           'created_at' =>'createdAt',
           'updated_at' =>'updatedAt',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
