<?php

namespace Controller;

use Model\Department;
use Model\DepartmentType;
use Src\Request;
use Src\Validator\Validator;
use Src\View;

class DepartmentController
{
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
}