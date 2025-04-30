<?php

namespace Controller;

use Model\Department;
use Model\DepartmentType;
use Model\Room;
use Model\RoomType;
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
        $departments = Department::all();
        return new View('site.departments', ['departments' => $departments]);
    }

    public function create_department(Request $request): string
    {
        if ($request->method === 'POST' && Department::create($request->all())) {
            app()->route->redirect('/departments');
        }
        $department_types = DepartmentType::all();
        return (new View())->render('site.create_department', ['department_types' => $department_types]);
    }

    public function create_department_type(Request $request): string
    {
        if ($request->method === 'POST' && DepartmentType::create($request->all())) {
            app()->route->redirect('/departments');
        }
        return (new View())->render('site.create_department_type');
    }

    public function create_room_type(Request $request): string
    {
        if ($request->method === 'POST' && RoomType::create($request->all())) {
            app()->route->redirect('/rooms');
        }
        return (new View())->render('site.create_room_type');
    }

    public function users(): string
    {
        $users = User::all();
        return new View('site.users', ['users' => $users]);
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
        return (new View())->render('site.create_user', ['roles' => $roles]);
    }
}