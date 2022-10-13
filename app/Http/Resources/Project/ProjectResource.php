<?php

namespace App\Http\Resources\Project;

use App\Http\Resources\BaseResource;

class ProjectResource extends BaseResource
{
    protected $availableRelations = [];

    protected $defaultRelations = [];

    protected $type = 'project';

    public function toArray($request)
    {
        return $this->transformResponse([
            'id' => $this->getIdentifier(),
            'name' => $this->name,
            'date' => $this->date,
            'estimate_start_date' => $this->estimate_start_date,
            'estimate_end_date' => $this->estimate_end_date,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}