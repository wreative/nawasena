<?php

namespace App\Repositories;

use App\Http\Presenters\PresenterInterface;

class BaseRepository
{
    protected $model;
    protected $query;
    protected $included;
    protected $presenter;
    protected $modelInstance;

    public function __construct(string $model)
    {
        $this->reinit($model);
    }

    public function reinit(string $model)
    {
        $this->model = $model;
        $this->modelInstance = null;
        $this->query = null;
        $this->included = [];
    }

    public function getModel()
    {
        if (!$this->modelInstance) {
            $this->modelInstance = app()->make($this->model);
        }

        return $this->modelInstance;
    }

    public function setPresenter(PresenterInterface $presenter)
    {
        $this->presenter = $presenter;
    }
}