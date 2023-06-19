<?php

namespace Controller;

use Model\Book;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Site
{
    public
    function main_page(): string
    {
        $book_list = Book::all();
        return (new View())->render('site.main_page', ['book_list' => $book_list]);
    }

    public
    function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/login');
        }
        return new View('site.signup');
    }


    public
    function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt([
                'login' => $request->login,
                'password' => $request->password
            ]
        )) {
            app()->route->redirect('/');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public
    function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/');
    }

    public
    function profile(Request $request): string
    {
        if ($request->method === 'POST' && User::update($request->all())) {
            app()->route->redirect('/');
        }
        return new View('site.profile');
    }


}