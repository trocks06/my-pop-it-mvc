<?php

namespace Controller;

use Model\Role;
use Model\User;
use Src\View;
use Src\Request;
use Src\Auth\Auth;

class Site
{
    public function index(Request $request): string
    {
        $roles = Role::all();
        return (new View())->render('site.signup', ['roles' => $roles]);
    }

    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Главная страница Внутренней телефонной связи :)']);
    }

    public function subscribers(): string
    {
        return new View('site.subscribers');
    }

    public function phones(): string
    {
        return new View('site.phones');
    }

    public function rooms(): string
    {
        return new View('site.rooms');
    }

    public function departments(): string
    {
        return new View('site.departments');
    }

    public function users(): string
    {
        return new View('site.users');
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/login');
        }
        $roles = Role::all();
        return (new View())->render('site.signup', ['roles' => $roles]);
    }

    public function login(Request $request): string
    {
        //Если просто обращение к странице, то отобразить форму
        if ($request->method === 'GET') {
            return new View('site.login');
        }
        //Если удалось аутентифицировать пользователя, то редирект
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }
        //Если аутентификация не удалась, то сообщение об ошибке
        return new View('site.login', ['message' => 'Неправильные логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/hello');
    }

    public function create_user(Request $request): string
    {
        if ($request->method === 'POST' && User::create($request->all())) {
            app()->route->redirect('/users');
        }
        $roles = Role::all();
        return (new View())->render('site.signup', ['roles' => $roles]);
    }
}