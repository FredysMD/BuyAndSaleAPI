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
}
