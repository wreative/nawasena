<?php

namespace App\Repositories\Items;

use Illuminate\Http\Request;
use App\Repositories\BaseRepository;
use App\Http\Presenters\DataPresenter;
use App\Http\Requests\ItemsRequest;
use App\Http\Resources\Items\ItemsResource;
use App\Models\Items;
use Illuminate\Support\Facades\Hash;

class ItemsRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(Items::class);
    }

    public function browse(Request $request)
    {
        $this->query = $this->getModel();
        $presenter = new DataPresenter(ItemsResource::class, $request);

        return $presenter
            ->preparePager()
            ->renderCollection($this->query);
    }

    public function store(ItemsRequest $request)
    {
        try {
            $data = $this->getModel()->create([
                'name' => $request->name,
                'qty' => $request->qty,
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
        $presenter = new DataPresenter(ItemsResource::class, $request);

        return $presenter->render($this->query);
    }

    public function update($id, ItemsRequest $request)
    {
        try {
            $data = Items::findOrFail($id);
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
            Items::findOrFail($id)->delete();

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