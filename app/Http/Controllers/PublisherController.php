<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherCollection;
use App\Http\Resources\PublisherResource;
use App\Publisher;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class PublisherController extends Controller
{

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return PublisherCollection
     */
    public function index(Request $request)
    {
        $name = $request->input('name');

        $publisher = Publisher::with('books')
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->paginate(5);
        return new PublisherCollection($publisher);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:100'
            ]);
            $publisher = Publisher::create($request->all());
            return response()->json([
                'id' => $publisher->id,
                'created_at' => $publisher->created_at,
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'errors' => $exception->errors(),
            ], 422);
        }

    }

    /**
     * Display the specified resource.
     * @param $id
     * @return PublisherResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $publisher = Publisher::with('books')->find($id);
        if (!$publisher) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        return new PublisherResource($publisher);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $publisher = Publisher::find($id);
        if (!$publisher) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $publisher->update($request->all());
        return response()->json(null, 204);
    }

    /**
     * Remove the specified resource from storage.
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        $publisher = Publisher::find($id);
        if (!$publisher) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $publisher->delete();
        return response()->json(null, 204);
    }
}
