<?php

namespace App\Http\Resources\User;

use App\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
    protected $availableRelations = [];

    protected $defaultRelations = [];

    protected $type = 'user';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id' => $this->getIdentifier(),
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'is_admin' => $this->is_admin,
            'email_verified_at' => $this->email_verified_at,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}