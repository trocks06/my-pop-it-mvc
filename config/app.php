<?php
return [
    //Класс аутентификации
    'auth' => \Src\Auth\Auth::class,
    //Клас пользователя
    'identity' => \Model\User::class,
    //Классы для middleware
    'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
        'admin' => \Middlewares\AdminMiddleware::class,
    ],
    'validators' => [
        'required' => \trocks06\Validators\Validators\RequireValidator::class,
        'unique' => \trocks06\Validators\Validators\UniqueValidator::class,
        'password' => \trocks06\Validators\Validators\PasswordValidator::class,
        'avatar' => \Validators\AvatarValidator::class,
        'birth_date' => \Validators\BirthDateValidator::class,
        'full_name' => \Validators\UniqueFullNameValidator::class,
        'phone' => \Validators\PhoneValidator::class,
    ],
    'routeAppMiddleware' => [
        'csrf' => \Middlewares\CSRFMiddleware::class,
        'trim' => \Middlewares\TrimMiddleware::class,
        'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
    ],
];