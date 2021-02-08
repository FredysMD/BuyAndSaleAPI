<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Buyer;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identity' => (int)$buyer->id,
            'name' => (string)$buyer->name,
            'email' => (string)$buyer->email,
            'verified' => (int)$buyer->verified,
            'createdAt' => (string)$buyer->created_at,
            'updatedAt' => (string)$buyer->updated_at,
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
}
