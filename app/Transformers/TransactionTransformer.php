<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Transaction;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identity' => (int)$transaction->id,
            'quantity' => (int)$transaction->quantity,
            'buyer' => (string)$transaction->buyer_id,
            'product' => (string)$transaction->product_id,
            'createdAt' => (string)$transaction->created_at,
            'updatedAt' => (string)$transaction->updated_at,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('transactions.show', $transaction->id),
                ],

                [
                    'rel' => 'transactions.buyers',
                    'href' => route('transactions.buyers.index', $transaction->id),
                ],

                [
                    'rel' => 'transactions.products',
                    'href' => route('transactions.products.index', $transaction->id),
                ],
                [
                    'rel' => 'transactions.sellers',
                    'href' => route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel' => 'transactions.categories',
                    'href' => route('transactions.categories.index', $transaction->id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identity' => 'id',
            'quantity' => 'quantity',
            'buyer' => 'buyer_id',
            'product' => 'product_id',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes =  [
           'id' => 'identity',
           'quantity' => 'quantity',
           'buyer_id' => 'buyer',
           'product_id' => 'product',
           'created_at' =>'createdAt',
           'updated_at' =>'updatedAt',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
    
}
