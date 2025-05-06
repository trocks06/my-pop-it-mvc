<?php

use Src\Route;

Route::add('GET', '/', [Controller\Site::class, 'hello']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add('GET', '/subscribers', [Controller\SubscriberController::class, 'subscribers'])->middleware('auth');
Route::add('GET', '/subscriber/{id}', [Controller\SubscriberController::class, 'subscriber'])->middleware('auth');
Route::add('GET', '/phones', [Controller\PhoneController::class, 'phones'])->middleware('auth');
Route::add('GET', '/rooms', [Controller\RoomController::class, 'rooms'])->middleware('auth');
Route::add('GET', '/departments', [Controller\DepartmentController::class, 'departments'])->middleware('auth');
Route::add('GET', '/users', [Controller\UserController::class, 'users'])->middleware('auth');
Route::add(['GET', 'POST'], '/create_user', [Controller\UserController::class, 'create_user'])->middleware('auth', 'admin');
Route::add(['GET', 'POST'], '/departments/create', [Controller\DepartmentController::class, 'create_department'])->middleware('auth');
Route::add(['GET', 'POST'], '/department_types/create', [Controller\DepartmentController::class, 'create_department_type'])->middleware('auth');
Route::add(['GET', 'POST'], '/rooms/create', [Controller\RoomController::class, 'create_room'])->middleware('auth');
Route::add(['GET', 'POST'], '/room_types/create', [Controller\RoomController::class, 'create_room_type'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/create', [Controller\SubscriberController::class, 'create_subscriber'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/count', [Controller\SubscriberController::class, 'count_subscribers'])->middleware('auth');
Route::add(['GET', 'POST'], '/phones/create', [Controller\PhoneController::class, 'create_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/attach_phone', [Controller\PhoneController::class, 'attach_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/detach_phone/{id}', [Controller\PhoneController::class, 'detach_phone'])->middleware('auth');
Route::add(['GET', 'POST'], '/signup', [Controller\AuthController::class, 'signup']);
Route::add(['GET', 'POST'], '/login', [Controller\AuthController::class, 'login']);
Route::add('GET', '/logout', [Controller\AuthController::class, 'logout']);