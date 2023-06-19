<?php

namespace Controller;

use Model\Publisher;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class PublisherView
{
    public
    function publisher_list(): string
    {
        $publisher_list = Publisher::all();
        return (new View())->render('site.publisher.publishers', ['publisher_list' => $publisher_list]);
    }

    public
    function publisher_add(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'name' => ['required'],
            ], [
                'required' => 'Поле :field пусто',
            ]);
            if ($validator->fails()) {
                $message = json_encode($validator->errors(), JSON_UNESCAPED_UNICODE);
                return new View('site.publisher.publisher_add', ['errors' => $message]);
            }

            if (Publisher::create($request->all())) {
                app()->route->redirect('/publishers');
            }
        }
        return new View('site.publisher.publisher_add');
    }
}