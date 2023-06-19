<?php

use Src\Route;

Route::add('GET', '/book_list', [Controller\api\Api::class, 'book_list']);
Route::add('GET', '/reader_list', [Controller\api\Api::class, 'reader_list']);
Route::add('POST', '/login', [Controller\api\Api::class, 'login']);
Route::add('POST', '/logout', [Controller\api\Api::class, 'logout']);

Route::add('POST', '/', [Controller\api\Api::class, 'echo']);