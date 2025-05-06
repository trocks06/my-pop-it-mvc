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
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Главная страница Внутренней телефонной связи :)']);
    }
}