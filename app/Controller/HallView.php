<?php

namespace Controller;

use Model\Hall;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class HallView
{
    public
    function hall_list(): string
    {
        $hall_list = Hall::all();
        return (new View())->render('site.hall.halls', ['hall_list' => $hall_list]);
    }

    public
    function hall_add(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'number' => ['required', 'number'],
                'appointment' => ['required', 'letter']
            ], [
                'letter' => 'Поле :field должно содержать только буквы ',
                'required' => 'Поле :field пусто',
                'number' => 'Поле :filed должно содержать только цифры'
            ]);
            if ($validator->fails()) {
                $message = json_encode($validator->errors(), JSON_UNESCAPED_UNICODE);
                return new View('site.hall.hall_add', ['errors' => $message]);
            } else if (Hall::create($request->all())) {
                app()->route->redirect('/halls');
            }
        }
        return new View('site.hall.hall_add');
    }

}