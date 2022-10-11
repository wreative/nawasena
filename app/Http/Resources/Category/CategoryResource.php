<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\BaseResource;

class CategoryResource extends BaseResource
{
    protected $availableRelations = [];

    protected $defaultRelations = [];

    protected $type = 'category';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id' => $this->getIdentifier(),
            'name' => $this->name,
            'font_color' => $this->font_color,
            'color' => $this->color,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}