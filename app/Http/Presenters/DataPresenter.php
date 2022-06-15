<?php

namespace App\Http\Presenters;

use Exception;

use Illuminate\Http\Request;

class DataPresenter implements PresenterInterface
{
    protected $resource;
    protected $data;
    protected $rawResource;
    protected $included = [];
    protected $activeRelations = null;
    protected $request;
    protected $pagination = [
        'limit' => 20,
        'num' => 1,
    ];

    public function __construct(String $resource, Request $request)
    {
        $this->resource = $resource;
        $this->request = $request;

        $this->rawResource = new $this->resource(null);
    }

    public function render($query)
    {
        $query = $this->parseIncludes($query);
        $data = $query->first();

        if ($data === null) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found',
            ], 404);
        }

        $resourceInstance = new $this->resource($data);

        foreach ($this->getActiveRelations() as $relationship) {
            $resourceInstance->addRelationship($relationship);

            $this->included[$relationship] = $resourceInstance->parseRelation($relationship);
        }

        $response = [
            'success' => true,
            'data' => $resourceInstance,
            'included' => $this->getIncluded(),
            'meta' => [
                'relations' => $this->getActiveRelations(),
                'available_relations' => $this->getAvailableRelations(),
                'links' => [
                    'self' => url()->current(),
                ]
            ],
        ];

        return $response;
    }

    public function renderCollection($query)
    {
        try {
            if ($this->request->hasHeader('count-only')) {
                $conly = filter_var($this->request->header('count-only'), FILTER_VALIDATE_BOOLEAN);
            } else {
                $conly = false;
            }

            if (!$conly) {
                $query = $this->parseIncludes($query);
                $query = $this->applyPagination($query);
            }

            $baseQuery = $query->toBase();

            $total = $baseQuery->getCountForPagination();
            $data = $query->get();
            $count = $data->count();

            $resourceInstance = $this->resource::collection($data);

            if ($conly) {
                return [
                    'success' => $total > 0 ? true : false,
                    'count' => $count
                ];
            } else {
                foreach ($this->getActiveRelations() as $relationship) {
                    foreach ($resourceInstance as $resource) {
                        $resource->addRelationship($relationship);
                    }

                    $this->included[$relationship] = $resourceInstance->parseRelation($relationship);
                }

                return [
                    'success' => $total > 0 ? true : false,
                    'data' => $resourceInstance,
                    'included' => $this->getIncluded(),
                    'meta' => [
                        'relations' => $this->getActiveRelations(),
                        'available_relations' => $this->getAvailableRelations(),
                        'links' => [
                            'self' => url()->current(),
                        ],
                        'pagination' => [
                            'limit' => (int) $this->pagination['limit'],
                            'page' => (int) $this->pagination['num'],
                            'count' => $count,
                            'total' => $total,
                        ]
                    ],
                ];
            }
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function applyPagination($query)
    {
        return $query
            ->take($this->pagination['limit'])
            ->skip(($this->pagination['num'] - 1) * $this->pagination['limit']);
    }

    public function getActiveRelations()
    {
        if ($this->activeRelations !== null) {
            return $this->activeRelations;
        }


        $include = $this->request->input('include');
        if ($include === null) {
            $this->activeRelations = $this->rawResource->getDefaultRelations();
        } else {
            $include = explode(',', $include);
            $validatedInclude = $this->validateInclude($include);

            $this->activeRelations = array_unique(array_merge(
                $validatedInclude,
                $this->rawResource->getDefaultRelations()
            ), SORT_REGULAR);
        }

        // Prevent showing random & unsorted keys
        return array_values($this->activeRelations);
    }

    public function validateInclude($includes)
    {
        $availableIncludes = $this->getAvailableRelations();
        return array_filter($includes, function ($item) use ($availableIncludes) {
            return in_array($item, $availableIncludes);
        });
    }

    public function getAvailableRelations()
    {
        return $this->rawResource->getAvailableRelations();
    }

    public function parseIncludes($query)
    {
        foreach ($this->getActiveRelations() as $include) {
            $query = $query->with($include);
        }

        return $query;
    }

    public function getRelationships()
    {
        return [];
    }

    public function getIncluded()
    {
        return $this->included;
    }

    public function preparePager()
    {
        $pagination = $this->request->input('page');
        $this->pagination['num'] = (int) isset($pagination['num']) ? $pagination['num'] : 1;
        $this->pagination['limit'] = (int) isset($pagination['limit']) ? $pagination['limit'] : 20;

        return $this;
    }
}