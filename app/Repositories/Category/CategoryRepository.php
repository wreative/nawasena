<?php

namespace App\Repositories\Category;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Http\Presenters\DataPresenter;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }

    public function browse(Request $request)
    {
        $this->query = $this->getModel();
        $presenter = new DataPresenter(CategoryResource::class, $request);

        return $presenter
            ->preparePager()
            ->renderCollection($this->query);
    }

    public function store(CategoryRequest $request)
    {
        try {
            $data = $this->getModel()->create([
                'name' => $request->name,
                'font_color' => $request->font_color,
                'color' => $request->color,
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
        $presenter = new DataPresenter(CategoryResource::class, $request);

        return $presenter->render($this->query);
    }

    public function update($id, CategoryRequest $request)
    {
        try {
            $data = Category::findOrFail($id);
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
            Category::findOrFail($id)->delete();

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