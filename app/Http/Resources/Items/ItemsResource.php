<?php

namespace App\Http\Resources\Items;

use App\Http\Resources\BaseResource;

class ItemsResource extends BaseResource
{
    protected $availableRelations = [];

    protected $defaultRelations = [];

    protected $type = 'items';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id' => $this->getIdentifier(),
            'name' => $this->name,
            'qty' => $this->qty,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}