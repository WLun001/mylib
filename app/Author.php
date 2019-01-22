<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Author
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Author query()
 * @mixin \Eloquent
 */
class Author extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }
}
