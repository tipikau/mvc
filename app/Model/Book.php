<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['name', 'author', 'date_publish', 'price', 'annotation', 'new', 'genre_id', 'hall_id', 'publisher_id', 'rent', 'cover', 'isbn'];
}
