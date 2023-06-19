<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'can' => \Middlewares\CanMiddleware::class,
    ],
    'validators' => [
        'required' => \Validators\RequireValidator::class,
        'unique' => \Validators\UniqueValidator::class,
        'number' => \Validators\NumberValidator::class,
        'letters' => \Validators\LetterValidator::class,

    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
        'json' => \Middlewares\JSONMiddleware::class,
    ],
    'providers' => [
        'kernel' => Src\Provider\KernelProvider::class,
        'route' => Src\Provider\RouteProvider::class,
        'db' => Src\Provider\DBProvider::class,
        'auth' => Src\Provider\AuthProvider::class,
    ],
];
