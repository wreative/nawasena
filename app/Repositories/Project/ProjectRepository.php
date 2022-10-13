<?php

namespace App\Repositories\Project;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Http\Presenters\DataPresenter;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class ProjectRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Project::class);
    }

    public function browse(Request $request)
    {
        $this->query = $this->getModel();
        $presenter = new DataPresenter(ProjectResource::class, $request);

        return $presenter
            ->preparePager()
            ->renderCollection($this->query);
    }

    public function store(ProjectRequest $request)
    {
        try {
            $data = $this->getModel()->create([
                'name' => $request->name,
                'date' => $request->date,
                'estimate_start_date' => $request->estimate_start_date,
                'estimate_end_date' => $request->estimate_end_date,
            ]);

            return $this->show($data->id, $request);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id, Request $request)
    {
        $this->query = $this->getModel()->where('id', $id);
        $presenter = new DataPresenter(ProjectResource::class, $request);

        return $presenter->render($this->query);
    }

    public function update($id, ProjectRequest $request)
    {
        try {
            $data = Project::findOrFail($id);
            $data->update($request->all());

            return $this->show($id, $request);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            Project::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'data has been deleted'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}