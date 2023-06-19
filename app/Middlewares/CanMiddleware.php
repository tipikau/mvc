<?php

namespace Middlewares;

use Exception;
use Src\Auth\Auth;
use Src\Request;

class CanMiddleware
{
    public function handle(Request $request, string $roles): void
    {
        if (!Auth::user()->hasRole(explode('|', $roles))) {
            throw new Exception('Доступ закрыт для вас');
        }
    }
}