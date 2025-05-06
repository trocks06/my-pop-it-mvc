<?php

namespace Controller;

use Model\Role;
use Model\User;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class UserController
{
    public function users(Request $request): string
    {
        $query = User::query();

        if ($search = $request->get('search_field')) {
            $search = trim($search);
            $query->where(function($q) use ($search) {
                $q->where('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('middle_name', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->get();

        return new View('site.users', ['users' => $users, 'request' => $request]);
    }

    public function create_user(Request $request): string
    {
        $roles = Role::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'login' => ['required', 'unique:user,login'],
                'password' => ['required', 'password'],
                'avatar' => ['avatar:user,avatar'],
                'role_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Пользователь с таким логином уже существует',
                'password' => 'Пароль должен быть длиной не менее 8 символов и содержать цифры, заглавные и строчные буквы',
                'avatar' => 'Размер аватара должен быть не более 2мб, допустимые форматы: jpg, jpeg, png, gif',
            ]);

            if ($validator->fails()) {
                return new View('site.create_user', [
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
                app()->route->redirect('/users');
            }
        }

        return (new View())->render('site.create_user', ['roles' => $roles]);
    }

}