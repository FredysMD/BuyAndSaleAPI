<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Category;

class CategoryTransformer extends TransformerAbstract
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
    public function transform(Category $category)
    {
        return [
            'identity' => (int)$category->id,
            'title' => (string)$category->name,
            'details' => (string)$category->description,
            'createdAt' => (string)$category->created_at,
            'updatedAt' => (string)$category->updated_at,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes =  [
            'identity' => 'id',
            'title' => 'name',
            'details' => 'description',
            'createdAt' => 'created_at',
            'updatedAt' => 'updated_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
