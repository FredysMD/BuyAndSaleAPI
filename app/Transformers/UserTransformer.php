<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\User;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identity' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'verified' => (int)$user->verified,
            'admin' => ($user->admin === 'true'),
            'createdAt' => (string)$user->created_at,
            'updatedAt' => (string)$user->updated_at,
        ];
    }
}
