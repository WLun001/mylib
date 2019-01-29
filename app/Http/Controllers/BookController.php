<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Book::all();
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
     * @return Book|Book[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse|null
     */
    public function show($id)
    {
        $book = Book::with("authors")->find($id);
        if (!$book) {
            return response()->json([
                'error' => 404,
                'message' => 'Not found',
            ], 404);
        }
        return $book;
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
