<?php

namespace Controller\api;

use Model\Book;
use Model\Reader;
use Src\Auth\Auth;
use Src\Request;
use Src\View;

class Api
{
    public function book_list(Request $request): void
    {

        if (app()->auth::user()->token) {


            $posts = Book::all()->toArray();

            (new View())->toJSON($posts);
        }
    }

    public function reader_list(Request $request): void
    {
        if (app()->auth::user()->token) {
            $posts = Reader::all()->toArray();

            (new View())->toJSON($posts);
        }
    }


    public function login(Request $request)
    {

        if ($request->method === 'POST') {
            if (Auth::attempt(['login' => $request->login,
                'password' => $request->password])) {

                $token = app()->auth::generateToken();
                Auth::user()->update(['token' => $token]);
                $users = app()->auth::user()->toArray();
                (new View())->toJSON((array)($users['token']));
            } else {
                (new View())->toJSON((array)'Login failed');
            }
        }
    }

    public function logout(Request $request): void
    {
        if (!Auth::attempt($request->all())) {
            $token = null;
            Auth::user()->update([
                'token' => $token
            ]);
        }
        Auth::logout();
        (new View())->toJSON((array)'logout');

    }

    public function echo(Request $request): void
    {
        (new View())->toJSON($request->all());
    }
}
