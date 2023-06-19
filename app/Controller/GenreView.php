<?php

namespace Controller;

use Model\Genre;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class GenreView
{
    public
    function genre_list(): string
    {
        $genre_list = Genre::all();
        return (new View())->render('site.genre.genrs', ['genre_list' => $genre_list]);
    }

    public
    function genre_add(Request $request): string
    {
        if ($request->method === 'POST' && Genre::create($request->all())) {
            $validator = new Validator($request->all(), [
                'name' => ['required']
            ], [
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                $message = json_encode($validator->errors(), JSON_UNESCAPED_UNICODE);
                return new View('site.genre.genre_add', ['errors' => $message]);
            }

            app()->route->redirect('/genres');
        }
        return new View('site.genre.genre_add');
    }
}