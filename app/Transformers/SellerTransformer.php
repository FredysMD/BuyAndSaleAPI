<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Seller;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identity' => (int)$seller->id,
            'name' => (string)$seller->name,
            'email' => (string)$seller->email,
            'verified' => (int)$seller->verified,
            'createdAt' => (string)$seller->created_at,
            'updatedAt' => (string)$seller->updated_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('sellers.show', $seller->id),
                ],

                [
                    'rel' => 'sellers.buyers',
                    'href' => route('sellers.buyers.index', $seller->id),
                ],

                [
                    'rel' => 'sellers.categories',
                    'href' => route('sellers.categories.index', $seller->id),
                ],
                [
                    'rel' => 'sellers.products',
                    'href' => route('sellers.products.index', $seller->id),
                ],
                [
                    'rel' => 'sellers.transactions',
                    'href' => route('sellers.transactions.index', $seller->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identity' => 'id',
            'name' => 'name',
            'email' => 'email',
            'verified' => 'verified',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
           'id' => 'identity',
           'name' =>    'name',
           'email' => 'email',
           'verified' => 'verified',
           'created_at' =>'createdAt',
           'updated_at' =>'updatedAt',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
