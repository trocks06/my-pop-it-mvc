<?php

namespace Controller;

use Model\Subscriber;
use Model\Department;
use Model\DepartmentType;
use Model\Phone;
use Model\Room;
use Model\RoomType;
use Model\Role;
use Model\User;
use Src\View;
use Src\Request;
use Src\Auth\Auth;
use Src\Validator\Validator;

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

    public function subscriber($id): string
    {
        $subscriber = Subscriber::find($id);
        $phones = Phone::where('subscriber_id', $id)->get();

        $depatmentName = Department::find($subscriber->department_id)->department_name;

        return new View('site.subscriber', ['subscriber' => $subscriber, 'departmentName' => $depatmentName, 'phones' => $phones]);
    }

    public function subscribers(Request $request): string
    {
        $query = Subscriber::query();

        if ($search = $request->get('search_field')) {
            $search = trim($search);
            $query->where(function($q) use ($search) {
                $q->where('last_name', 'LIKE', "%{$search}%")
                    ->orWhere('first_name', 'LIKE', "%{$search}%")
                    ->orWhere('middle_name', 'LIKE', "%{$search}%");
            });
        }

        $subscribers = $query->get();

        return new View('site.subscribers', [
            'subscribers' => $subscribers,
            'request' => $request
        ]);
    }

    public function phones(Request $request): string
    {
        $query = Phone::query();

        if ($search = $request->get('search_field')) {
            $query->where('phone_number', 'LIKE', "%{$search}%");
        }

        $phones = $query->get();

        return new View('site.phones', ['phones' => $phones, 'request' => $request]);
    }

    public function rooms(Request $request): string
    {
        $query = Room::query();

        if ($search = $request->get('search_field')) {
            $query->where('room_name', 'LIKE', "%{$search}%");
        }

        $rooms = $query->get();

        return new View('site.rooms', ['rooms' => $rooms, 'request' => $request]);
    }

    public function departments(Request $request): string
    {
        $query = Department::query();

        if ($search = $request->get('search_field')) {
            $query->where('department_name', 'LIKE', "%{$search}%");
        }

        $departments = $query->get();

        return new View('site.departments', ['departments' => $departments, 'request' => $request]);
    }

    public function create_department(Request $request): string
    {
        $department_types = DepartmentType::all();
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'department_name' => ['required', 'unique:department,department_name'],
                'department_type_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Подразделение с таким названием уже существует',
            ]);

            if ($validator->fails()) {
                return new View('site.create_department', [
                    'errors' => $validator->errors(),
                    'department_types' => $department_types,
                    'old' => $request->all()
                ]);
            }

            if (Department::create($request->all())) {
                app()->route->redirect('/departments');
            }
        }
        return (new View())->render('site.create_department', ['department_types' => $department_types]);
    }

    public function create_department_type(Request $request): string
    {
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'type_name' => ['required', 'unique:department_type,type_name'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Такой вид помещения уже существует',
            ]);

            if ($validator->fails()) {
                return new View('site.create_department_type', [
                    'errors' => $validator->errors(),
                    'old' => $request->all()
                ]);
            }

            if (DepartmentType::create($request->all())) {
                app()->route->redirect('/departments');
            }
        }
        return (new View())->render('site.create_department_type');
    }

    public function create_room(Request $request): string
    {
        $room_types = RoomType::all();
        $departments = Department::all();
        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'room_name' => ['required', 'unique:room,room_name'],
                'department_id' => ['required'],
                'room_type_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Помещение с таким названием уже существует',
            ]);

            if ($validator->fails()) {
                return new View('site.create_room', [
                    'errors' => $validator->errors(),
                    'room_types' => $room_types,
                    'departments' => $departments,
                    'old' => $request->all()
                ]);
            }

            if (Room::create($request->all())) {
                app()->route->redirect('/rooms');
            }
        }
        return (new View())->render('site.create_room', ['room_types' => $room_types, 'departments' => $departments]);
    }

    public function create_room_type(Request $request): string
    {
        if ($request->method === 'POST') {

            $validator = new Validator($request->all(), [
                'type_name' => ['required', 'unique:room_type,type_name'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Такой вид помещения уже существует',
            ]);

            if ($validator->fails()) {
                return new View('site.create_room_type', [
                    'errors' => $validator->errors(),
                    'old' => $request->all()
                ]);
            }

            if (RoomType::create($request->all())) {
                app()->route->redirect('/rooms');
            }
        }
        return (new View())->render('site.create_room_type');
    }

    public function create_phone(Request $request): string
    {
        $subscribers = Subscriber::all();
        $rooms = Room::all();

        if ($request->method === 'POST') {
            $validator = new Validator($request->all(), [
                'phone_number' => ['required', 'unique:phone,phone_number', 'phone'],
                'room_id' => ['required'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Пользователь с таким логином уже существует',
                'phone' => 'Поле :field должно содержать корректный номер телефона, пример: +7(999)123-45-67'
            ]);

            if ($validator->fails()) {
                return new View('site.create_phone', [
                    'errors' => $validator->errors(),
                    'subscribers' => $subscribers,
                    'rooms' => $rooms,
                    'old' => $request->all()
                ]);
            }

            if(!$request->get('subscriber_id')) {
                $request->set('subscriber_id', null);
            }

            if (Phone::create($request->all())) {
                app()->route->redirect('/phones');
            }
        }
        return (new View())->render('site.create_phone', ['subscribers' => $subscribers, 'rooms' => $rooms]);
    }

    public function create_subscriber(Request $request): string
    {
        $departments = Department::all();
        if ($request->method === 'POST') {
            $request->set('full_name', implode(' ', [
                $request->get('last_name'),
                $request->get('first_name'),
                $request->get('middle_name')
            ]));
            $validator = new Validator($request->all(), [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'birth_date' => ['required', 'birth_date'],
                'department_id' => ['required'],
                'full_name' => ['full_name'],
            ], [
                'required' => 'Поле :field обязательно для заполнения',
                'unique' => 'Пользователь с таким логином уже существует',
                'password' => 'Пароль должен быть длиной не менее 8 символов и содержать цифры, заглавные и строчные буквы',
                'avatar' => 'Размер аватара должен быть не более 2мб, допустимые форматы: jpg, jpeg, png, gif',
                'birth_date' => 'Поле :field должно содержать корректную дату (возраст от 18 до 120 лет)',
                'full_name' => 'Абонент с такими ФИО уже существует',
            ]);

            if ($validator->fails()) {
                return new View('site.create_subscriber', [
                    'errors' => $validator->errors(),
                    'departments' => $departments,
                    'old' => $request->all()
                ]);
            }

            if (Subscriber::create($request->all())) {
                app()->route->redirect('/subscribers');
            }
        }
        return (new View())->render('site.create_subscriber', ['departments' => $departments]);
    }

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

    public function attach_phone(Request $request): string
    {
        $subscribers = Subscriber::all();
        $phones = Phone::where('subscriber_id', null)->get();
        if ($request->method === 'POST') {
            $choicePhone = $request->get('phone_id');
            $choiceSubscriber = $request->get('subscriber_id');

            if(!$choiceSubscriber || !$choicePhone) {
                $error = 'Нет доступных абонентов или телефонов';
                return (new View())->render('site.attach_number', [
                    'subscribers' => $subscribers,
                    'phones' => $phones,
                    'error' => $error,
                ]);
            }
            $phone = Phone::find($request->phone_id);
            $subscriber = Subscriber::find($request->subscriber_id);

            $phone->update([
                'subscriber_id' => $subscriber->id,
            ]);

            app()->route->redirect('/phones');
        }

        return (new View())->render('site.attach_number', [
            'subscribers' => $subscribers,
            'phones' => $phones
        ]);
    }

    public function detach_phone($id, Request $request)
    {
        $phone = Phone::find($id);

        $phone->subscriber_id = null;
        $phone->save();

        app()->route->redirect('/phones');
    }

    public function count_subscribers(Request $request): string
    {
        $departments = Department::all();
        $rooms = Room::all();
        $subscribersCount = 0;

        $departmentId = $request->get('department_id');
        $roomId = $request->get('room_id');

        if ($request->method === 'GET') {
            $query = Subscriber::query();

            if ($departmentId) {
                $query->where('department_id', $departmentId);
            }

            if ($roomId) {
                $query->whereHas('phones', function($q) use ($roomId) {
                    $q->where('room_id', $roomId);
                });
            }

            $subscribersCount = $query->count();
        }

        return (new View())->render('site.count_subscribers', [
            'departments' => $departments,
            'rooms' => $rooms,
            'subscribersCount' => $subscribersCount
        ]);
    }
}