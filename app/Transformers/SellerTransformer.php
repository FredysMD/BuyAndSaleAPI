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
