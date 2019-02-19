<?php

namespace App\Http\Controllers;

use App\Author;
use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->input('name');

        $author = Author::with('books')
            ->when($name, function ($query) use ($name) {
                return $query->where('name', 'like', "%$name%");
            })
            ->get();
        return new AuthorCollection($author);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $author = Author::create($request->all());
        return response()->json([
            'id' => $author->id,
            'created_at' => $author->created_at,
        ], 201);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return AuthorResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $author = Author::with('books')->find($id);
        if (!$author) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $author->update($request->all());
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
        $author = Author::find($id);
        if (!$author) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $author->delete();
        return response()->json(null, 204);
    }
}
