<?php

namespace App\Http\Controllers;

use App\Book;
use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BookCollection(Book::all());
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $book = Book::create($request->all());
        $book->authors()->sync($request->authors);
        return response()->json([
            'id' => $book->id,
            'created_at' => $book->created_at,
        ], 201);
    }

    /**
     * Display the specified resource.
     * @param $id
     * @return BookResource|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $book = Book::with('authors')->with('publisher')->find($id);
        if (!$book) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        return new BookResource($book);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $book->update($request->all());
        $book->authors()->sync($request->authors);
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
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        $book->delete();
        return response()->json(null, 204);
    }
}
