<?php

namespace Controller;

use Model\Role;
use Model\User;
use Src\Auth\Auth;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class AuthController
{
    public function signup(Request $request): string
    {
        $roles = Role::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'login' => ['required', 'unique:user,login'],
                'password' => ['required', 'password'],
                'avatar' => ['avatar'],
                'role_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Пользователь с таким логином уже существует',
                'password' => 'Пароль должен быть длиной не менее 8 символов и содержать цифры, заглавные и строчные буквы',
                'avatar' => 'Размер аватара должен быть не более 2мб, допустимые форматы: jpg, jpeg, png, gif',
            ]);

            if ($validator->fails()) {
                return new View('site.signup', [
                    'errors' => $validator->errors(),
                    'roles' => $roles,
                    'old' => $request->all()
                ]);
            }

            $data = $request->all();

            if ($request->avatar) {
                $user = new User();
                $avatarPath = $user->uploadAvatar($request->file('avatar'));

                if ($avatarPath) {
                    $data['avatar'] = $avatarPath;
                }
            }

            if (User::create($data)) {
                app()->route->redirect('/login');
            }
        }

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

}