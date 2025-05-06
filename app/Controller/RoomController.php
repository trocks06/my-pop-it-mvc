<?php

namespace Controller;

use Model\Department;
use Model\Room;
use Model\RoomType;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class RoomController
{
    public function rooms(Request $request): string
    {
        $query = Room::query();

        if ($search = $request->get('search_field')) {
            $query->where('room_name', 'LIKE', "%{$search}%");
        }

        $rooms = $query->get();

        return new View('site.rooms', ['rooms' => $rooms, 'request' => $request]);
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
}