<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublisherCollection;
use App\Http\Resources\PublisherResource;
use App\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new PublisherCollection(Publisher::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $publisher = Publisher::create($request->all());
        return response()->json([
            'id' => $publisher->id,
            'created_at' => $publisher->created_at,
        ], 201);
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
