<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Support\Traits\Macroable;

use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    use Macroable;

    protected $availableRelations = [];
    protected $defaultRelations = [];
    protected $relationships = [];
    protected $type = '';
    protected $identifiedBy = 'id';
    protected $model;

    public function toArray($request)
    {
        return $this->transformResponse(parent::toArray($request));
    }

    protected function transformResponse($array)
    {
        $request = request();
        $filtered = collect($array);

        if ($this->resource !== null) {
            if ($request->filled('fields')) {
                if (isset($request->fields[$this->type])) {
                    $fields = explode(',', $request->fields[$this->type]);

                    array_unshift($fields, 'id');
                    $fields = array_unique($fields);

                    $filtered = $filtered->only($fields);
                } elseif (isset($request->fields['-' . $this->type])) {
                    $fields = explode(',', $request->fields['-' . $this->type]);

                    $fields = array_values(array_diff($fields, ['id']));
                    $filtered = $filtered->except($fields);
                }
            }

            $array = $filtered->all();

            $response = [
                'type' => $this->getType(),
                'id' => (string) $this->getIdentifier(),
                'attributes' => $array,
            ];

            $relationships = $this->getLoadedRelationships();

            if (count($relationships) > 0) {
                $response['relationships'] = $relationships;
            }

            return $response;
        }

        return [];
    }

    public function getAvailableRelations()
    {
        return $this->availableRelations;
    }

    public function getDefaultRelations()
    {
        return $this->defaultRelations;
    }

    public function getIdentifiedBy()
    {
        return $this->identifiedBy;
    }

    public function getIdentifier()
    {
        if (isset($this->pivot->{$this->identifiedBy})) {
            return $this->pivot->{$this->identifiedBy};
        } else if (isset($this->{$this->identifiedBy})) {
            return $this->{$this->identifiedBy};
        }

        return null;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLoadedRelationships()
    {
        $related = [];
        foreach ($this->relationships as $relationship) {
            $relation = $this->getRelationshipFor($relationship);

            if ($relation !== null) {
                $related[$relationship] = $relation;
            }
        }

        return $related;
    }

    protected function getRelationshipFor($relationship)
    {
        $methodName = 'get' . Str::studly($relationship) . 'Relation';
        $relationship = $this->$methodName();

        if ($relationship->resource !== null && $relationship->collects) {
            return $relationship->map(function ($item) {
                return [
                    'type' => $item->getType(),
                    'id' => (string) $item->getIdentifier()
                ];
            });
        }

        if ($relationship->resource !== null) {
            return [
                'type' => $relationship->getType(),
                'id' => (string) $relationship->getIdentifier(),
            ];
        }

        return null;
    }

    public function addRelationship($relationship)
    {
        $this->relationships[] = $relationship;
    }
}