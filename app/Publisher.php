<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Publisher
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Book[] $books
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Publisher query()
 * @mixin \Eloquent
 */
class Publisher extends Model
{
    protected $fillable = [
        'name'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
