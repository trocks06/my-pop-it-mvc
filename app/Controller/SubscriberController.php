<?php

namespace Controller;

use Model\Department;
use Model\Phone;
use Model\Room;
use Model\Subscriber;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class SubscriberController
{

    public function subscriber($id, Request $request): string
    {
        $selectedDepartment = $request->get('department_id');
        $subscriber = Subscriber::find($id);
        $departments = Department::all();
        $phonesQuery = Phone::where('subscriber_id', $id);

        if ($selectedDepartment) {
            $phonesQuery->whereHas('room', function ($query) use ($selectedDepartment) {
                $query->where('department_id', $selectedDepartment);
            });
        }

        $phones = $phonesQuery->get();

        $departmentName = Department::find($subscriber->department_id)->department_name;

        return new View('site.subscriber', ['subscriber' => $subscriber, 'departmentName' => $departmentName, 'phones' => $phones, 'departments' => $departments, 'selectedDepartment' => $selectedDepartment]);
    }

    public function subscribers(Request $request): string
    {
        $query = Subscriber::query();

        if ($search = $request->get('search_field')) {
            $search = trim($search);
            $query->where(function ($q) use ($search) {
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