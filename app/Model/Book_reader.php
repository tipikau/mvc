<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book_reader extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = ['book_id', 'reader_id', 'date_issue', 'date_back', 'librarian_id'];
}
