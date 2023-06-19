<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'main_page'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add(["GET", "POST"], '/books', [Controller\BookView::class, 'book_list'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(["GET", "POST"], '/book/', [Controller\BookView::class, 'book_detail'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/book-add', [Controller\BookView::class, 'book_add'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/book-update', [Controller\BookView::class, 'book_update'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/readers', [Controller\ReaderView::class, 'reader_list'])
    ->middleware('auth', 'can:admin|librarian');
Route::add('GET', '/reader', [Controller\ReaderView::class, 'reader'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/reader-add', [Controller\ReaderView::class, 'reader_add'])
    ->middleware('auth', 'can:admin|librarian');
Route::add(['GET', 'POST'], '/profile', [Controller\Site::class, 'profile'])
    ->middleware('auth', 'can:admin|librarian');

Route::add('GET', '/publishers', [Controller\PublisherView::class, 'publisher_list'])
    ->middleware('auth', 'can:admin');
Route::add(['GET', 'POST'], '/publisher-add', [Controller\PublisherView::class, 'publisher_add'])
    ->middleware('auth', 'can:admin');
Route::add('GET', '/genre', [Controller\GenreView::class, 'genre_list'])
    ->middleware('auth', 'can:admin');
Route::add(['GET', 'POST'], '/genre-add', [Controller\GenreView::class, 'genre_add'])
    ->middleware('auth', 'can:admin');
Route::add('GET', '/librarians', [Controller\LibView::class, 'lib_list'])
    ->middleware('auth', 'can:admin');
Route::add(['GET', 'POST'], '/librarian-add', [Controller\LibView::class, 'lib_add'])
    ->middleware('auth', 'can:admin');
Route::add('GET', '/halls', [Controller\HallView::class, 'hall_list'])
    ->middleware('auth', 'can:admin');
Route::add(['GET', 'POST'], '/hall-add', [Controller\HallView::class, 'hall_add'])
    ->middleware('auth', 'can:admin');

Route::add(['GET', 'POST'], '/reader-book', [Controller\ReaderView::class, 'book_reader'])
    ->middleware('auth', 'can:librarian|admin');
Route::add(['GET', 'POST'], '/book-delete', [Controller\BookView::class, 'delete_book'])
    ->middleware('auth', 'can:librarian|admin');





