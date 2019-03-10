<?php

use App\Book;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    $book = Book::withCount([
        'authors',
        'authors as authors_count' => function ($query) {
            $query->where('name', 'TWC');
        }
    ])->get();
    return $book;
});

Route::get('/books', 'WebController@books');
